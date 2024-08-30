// Function to show a specific section and hide others
function showSection(sectionId) {
    const sections = document.querySelectorAll('.content-section');
    sections.forEach(section => section.style.display = 'none');

    const sectionToShow = document.getElementById(sectionId);
    if (sectionToShow) {
        sectionToShow.style.display = 'block';
    } else {
        console.error(`Section with ID ${sectionId} not found.`);
    }

    const menuItems = document.querySelectorAll('#menu .items li');
    menuItems.forEach(item => {
        item.classList.remove('active');
        item.style.borderLeft = 'none';
    });

    const clickedItem = Array.from(menuItems).find(item => {
        const onClickFunc = item.onclick?.toString();
        return onClickFunc && onClickFunc.includes(sectionId);
    });

    if (clickedItem) {
        clickedItem.classList.add('active');
        clickedItem.style.borderLeft = '4px solid #fff';
    }
}

// Load users, PDF files, and class links on page load
window.onload = function() {
    showSection('dashboard'); // Show the dashboard initially
    loadUsers();
    loadPdfFiles();
    loadClassLinks(); // Ensure class links are loaded on page load
}

// Fetch and display users from the database
function loadUsers() {
    fetch('php/fetch_users.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(users => {
            const userList = document.getElementById('user-list');
            if (userList) {
                userList.innerHTML = ''; // Clear the table body before adding new rows

                users.forEach(user => {
                    const row = `<tr>
                        <td>${user.id}</td>
                        <td>${user.username}</td>
                        <td>${user.mobile_number}</td>
                        <td>${user.school}</td>
                        <td>${user.address}</td>
                        <td>${user.password}</td>
                        <td>
                            <button class="edit-btn" onclick="editUser(${user.id})">Edit</button>
                            <button class="delete-btn" onclick="deleteUser(${user.id})">Delete</button>
                        </td>
                    </tr>`;
                    userList.innerHTML += row;
                });
            } else {
                console.error('User list element not found.');
            }
        })
        .catch(error => {
            console.error('Error fetching user data:', error);
        });
}

// Populate the Edit User form with user details
function editUser(userId) {
    fetch(`php/get_user.php?id=${userId}`)
        .then(response => response.json())
        .then(user => {
            if (user.error) {
                alert(user.error);
                return;
            }

            // Populate the form with user data
            const form = document.querySelector('#edit-user-form');
            if (form) {
                form.querySelector('[name="user_id"]').value = user.id;
                form.querySelector('[name="username"]').value = user.username;
                form.querySelector('[name="mobile_number"]').value = user.mobile_number;
                form.querySelector('[name="school"]').value = user.school;
                form.querySelector('[name="address"]').value = user.address;
                form.querySelector('[name="password"]').value = ''; // Leave password field empty for security reasons

                // Change the form's submit button text to "Update User"
                const submitButton = form.querySelector('button');
                if (submitButton) {
                    submitButton.textContent = 'Update User';
                    submitButton.onclick = () => updateUser(userId);
                }

                // Show the Edit User section
                showSection('edit-users');
            } else {
                console.error('Edit user form not found.');
            }
        })
        .catch(error => {
            console.error('Error fetching user details:', error);
        });
}

// Update user details
function updateUser(userId) {
    const formData = new FormData(document.getElementById('edit-user-form'));
    formData.append('id', userId); // Append the user ID for updating

    fetch('php/update_user.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        alert(result); // Display the result (e.g., success message)
        loadUsers(); // Reload the users
        showSection('dashboard'); // Go back to the dashboard
    })
    .catch(error => {
        console.error('Error updating user:', error);
    });
}

// Delete user
function deleteUser(userId) {
    if (confirm('Are you sure you want to delete this user?')) {
        fetch(`php/delete_user.php?id=${userId}`, {
            method: 'DELETE'
        })
        .then(response => response.text())
        .then(result => {
            alert(result); // Display the result (e.g., success message)
            loadUsers(); // Reload the users
        })
        .catch(error => {
            console.error('Error deleting user:', error);
        });
    }
}

// Add new student
document.getElementById('add-student-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    const formData = new FormData(this);

    fetch('php/add_student.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        alert(result); // Display success or error message
        if (result.includes('success')) {
            this.reset(); // Reset the form
            showSection('dashboard'); // Show the dashboard section
            loadUsers(); // Reload the users
        }
    })
    .catch(error => {
        console.error('Error adding student:', error);
    });
});

// Upload PDF Files URL To Web
document.getElementById('pdf-upload-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData();
    formData.append('title', document.getElementById('pdf-title').value);
    formData.append('url', document.getElementById('pdf-url').value);

    fetch('php/upload_pdf_url.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        loadPdfFiles(); // Optionally reload or update the section with the new data
    })
    .catch(error => console.error('Error uploading PDF URL:', error));
});

// Load PDF files
function loadPdfFiles() {
    fetch('php/fetch_pdf_files.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(pdfFiles => {
            const pdfList = document.getElementById('pdf-list');
            if (pdfList) {
                pdfList.innerHTML = ''; // Clear the table body before adding new rows

                pdfFiles.forEach(pdf => {
                    const row = `<tr>
                        <td>${pdf.id}</td>
                        <td>${pdf.title}</td>
                         <td>
                            <a href="${pdf.url}" target="_blank" class="download-btn" download>Download</a> 
                        </td>
                        <td>
                            <button class="btn delete-btn" onclick="deletePdf(${pdf.id})">Delete</button>
                        </td>
                    </tr>`;
                    pdfList.innerHTML += row;
                });
            } else {
                console.error('PDF list element not found.');
            }
        })
        .catch(error => {
            console.error('Error fetching PDF files:', error);
        });
}

// Delete PDF file
function deletePdf(pdfId) {
    if (confirm('Are you sure you want to delete this PDF file?')) {
        fetch(`php/delete_pdf_file.php?id=${pdfId}`, {
            method: 'DELETE'
        })
        .then(response => response.text())
        .then(result => {
            alert(result); // Display the result (e.g., success message)
            loadPdfFiles(); // Reload the PDF files
        })
        .catch(error => {
            console.error('Error deleting PDF file:', error);
        });
    }
}

// Add class link form submission
document.getElementById('class-link-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch('php/add_class_link.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        alert(result);
        if (result.includes('success')) {
            this.reset(); // Reset the form
            showSection('live-class');
            loadClassLinks();
        }
    })
    .catch(error => console.error('Error adding class link:', error));
});

// Load class links
function loadClassLinks() {
    fetch('php/fetch_class_links.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(classLinks => {
            console.log('Class Links Data:', classLinks); // Check the console for data
            const classLinkList = document.getElementById('class-link-list');
            if (classLinkList) {
                classLinkList.innerHTML = ''; // Clear previous content

                if (classLinks.length > 0) {
                    classLinks.forEach(link => {
                        const row = `<tr>
                            <td>${link.id}</td>
                            <td>${link.date}</td>
                            <td>${link.time}</td>
                            <td><a href="${link.class_link}" target="_blank" class="btn">Open</a></td>
                            <td>${link.title}</td>
                            <td>
                                <button class="delete-btn" onclick="deleteClassLink(${link.id})">Delete</button>
                            </td>
                        </tr>`;
                        classLinkList.innerHTML += row;
                    });
                } else {
                    classLinkList.innerHTML = '<tr><td colspan="6">No class links found.</td></tr>';
                }
            } else {
                console.error('Class link list element not found.');
            }
        })
        .catch(error => {
            console.error('Error fetching class links:', error);
        });
}

// Delete class link
function deleteClassLink(classLinkId) {
    if (confirm('Are you sure you want to delete this class link?')) {
        fetch(`php/delete_class_link.php?id=${classLinkId}`, {
            method: 'DELETE'
        })
        .then(response => response.text())
        .then(result => {
            alert(result);
            loadClassLinks(); // Reload the class links
        })
        .catch(error => console.error('Error deleting class link:', error));
    }
}
