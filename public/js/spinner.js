document.getElementById('pdfDownloadButton').addEventListener('click', function(e) {
    e.preventDefault(); // Prevent default action of the link
    var url = this.href;
    
    // Show the spinner
    document.getElementById('loadingSpinner').style.display = 'block';

    // Use fetch to download the PDF
    fetch(url)
        .then(response => response.blob())
        .then(blob => {
            var link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'voters_profiles.pdf';
            link.click();
            // Hide the spinner
            document.getElementById('loadingSpinner').style.display = 'none';
        })
        .catch(() => {
            // Hide the spinner and show error message if needed
            document.getElementById('loadingSpinner').style.display = 'none';
            alert('Failed to generate PDF.');
        });
});