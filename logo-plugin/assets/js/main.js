document.addEventListener('DOMContentLoaded', function() {
    var uploadButton = document.getElementById('upload_logo_button');
    var logoFileInputRow = document.getElementById('logo_upload_row');
    
    uploadButton.addEventListener('click', function() {
        logoFileInputRow.style.display = 'table-row';
    });
});
