// Function to hide all sections
function hideAllSections() {
    document.querySelector('.user-list').style.display = 'none';
    document.querySelector('.dynamic-content').style.display = 'none';
}

// Show the user list when Dashboard is clicked
document.getElementById('dashboard-link').addEventListener('click', function() {
    hideAllSections();
    document.querySelector('.user-list').style.display = 'block';
});

// Show Add User form when Add User is clicked
document.getElementById('add-user-link').addEventListener('click', function() {
    hideAllSections();
    document.querySelector('.dynamic-content').style.display = 'block';
    document.querySelector('.dynamic-content').innerHTML = `
        <h2>Add User</h2>
        <form action="php/add_user.php" method="post">
    <input type="text" name="username" placeholder="User Name" required>
    <input type="text" name="mobile_number" placeholder="Mobile Number" required>
    <input type="text" name="school" placeholder="School" required>
    <input type="text" name="address" placeholder="Address" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Add User</button>
</form>
    `;
});

// Show PDF upload form when PDF Files is clicked
document.getElementById('pdf-files-link').addEventListener('click', function() {
    hideAllSections();
    document.querySelector('.dynamic-content').style.display = 'block';
    document.querySelector('.dynamic-content').innerHTML = `
        <h2>Upload PDF Files</h2>
       <form action="php/upload_pdf.php" method="post" enctype="multipart/form-data">
    <input type="file" name="pdf_file" accept=".pdf" required>
    <button type="submit">Upload</button>
</form>
    `;
});

// Show Lecture Link update form when Lecture Link is clicked
document.getElementById('class-link').addEventListener('click', function() {
    hideAllSections();
    document.querySelector('.dynamic-content').style.display = 'block';
    document.querySelector('.dynamic-content').innerHTML = `
        <h2>Update Lecture Link</h2>
       <form action="php/update_class_link.php" method="post">
    <input type="text" name="zoom_link" placeholder="Zoom Class Link" required>
    <button type="submit">Update</button>
</form>
    `;
});
