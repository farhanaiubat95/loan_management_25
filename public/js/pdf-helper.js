function drawPDFHeader(doc) {
  const pageWidth = doc.internal.pageSize.getWidth();

  // ===== LEFT SIDE : COMPANY NAME =====
  doc.setFontSize(16);
  doc.setTextColor(40);
  doc.setFont(undefined, "bold");
  doc.text("LONERY", 14, 18);

  // Optional tagline
  doc.setFontSize(9);
  doc.setFont(undefined, "normal");
  doc.setTextColor(100);
  doc.text("Loan Management System", 14, 24);

  // ===== RIGHT SIDE : COMPANY INFO =====
  doc.setFontSize(9);
  doc.setTextColor(60);

  doc.text("Email: support@company.com", pageWidth - 14, 18, {
    align: "right",
  });
  doc.text("Phone: +880 1234 567890", pageWidth - 14, 23, { align: "right" });
  doc.text("Address: Dhaka, Bangladesh", pageWidth - 14, 28, {
    align: "right",
  });

  // ===== SEPARATOR LINE =====
  doc.setDrawColor(200);
  doc.line(14, 32, pageWidth - 14, 32);
}

function drawPDFFooter(doc) {
  const pageCount = doc.internal.getNumberOfPages();
  const pageHeight = doc.internal.pageSize.height;

  for (let i = 1; i <= pageCount; i++) {
    doc.setPage(i);
    doc.setFontSize(8);
    doc.setTextColor(150);
    doc.text(`Page ${i} of ${pageCount}`, 196, pageHeight - 10, {
      align: "right",
    });
  }
}

function generatePDF({ title, headers, rows }) {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();

  // Header on first page
  drawPDFHeader(doc);

  // Title
  doc.setFontSize(13);
  doc.text(title, 14, 45);

  // Table
  doc.autoTable({
    startY: 50,
    head: [headers],
    body: rows,
    theme: "grid",

    // 👇 CENTER ALL TEXT
    styles: {
      fontSize: 9,
      cellPadding: 3,
      halign: "center", // horizontal center
      valign: "middle", // vertical center
    },

    headStyles: {
      fillColor: [39, 110, 35],
      textColor: 255,
      halign: "center", // header center
    },

    didDrawPage: function () {
      drawPDFHeader(doc); // header on every page
    },
  });

  drawPDFFooter(doc);
  doc.save(`${title.replace(/\s+/g, "_")}.pdf`);
}
