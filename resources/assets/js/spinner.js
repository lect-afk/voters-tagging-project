document.getElementById('pdfDownloadButton').addEventListener('click', function(e) {
    e.preventDefault(); // Prevent default action of the link
    var url = this.href;
    var filename = this.getAttribute('data-filename'); // Get the filename from data attribute
    
    // Show the spinner
    document.getElementById('loadingSpinner').style.display = 'block';

    // Use fetch to download the PDF
    fetch(url)
        .then(response => response.blob())
        .then(blob => {
            var link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = filename;
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