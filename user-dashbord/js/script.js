// Toggle the navigation menu for mobile view
function toggleMenu() {
    var navLinks = document.getElementById('nav-links');
    if (navLinks.classList.contains('show')) {
        navLinks.classList.remove('show');
    } else {
        navLinks.classList.add('show');
    }
}

// Close the navigation menu when clicking outside of it
document.addEventListener('click', function(event) {
    var navLinks = document.getElementById('nav-links');
    var hamburger = document.querySelector('.hamburger');
    if (!navLinks.contains(event.target) && !hamburger.contains(event.target)) {
        navLinks.classList.remove('show');
    }
});

// Show the edit information section
function showEditInfo() {
    hideAllSections();
    document.getElementById('edit-info-section').style.display = 'block';
}

// Show the live lectures section
function showLiveLectures() {
    hideAllSections();
    document.getElementById('live-lectures-section').style.display = 'block';
    fetchLectureDetails(); // Fetch lecture details when showing this section
}

// Show the PDF files section
function showPDFFiles() {
    hideAllSections();
    document.getElementById('pdf-files-section').style.display = 'block';
    fetchPDFFiles(); // Fetch PDF files when showing this section
}

// Show the contact us section
function showContactUs() {
    hideAllSections();
    document.getElementById('contact-us-section').style.display = 'block';
}

// Hide all sections
function hideAllSections() {
    document.getElementById('edit-info-section').style.display = 'none';
    document.getElementById('live-lectures-section').style.display = 'none';
    document.getElementById('pdf-files-section').style.display = 'none';
    document.getElementById('contact-us-section').style.display = 'none';
}

// Function to convert 24-hour time to 12-hour AM/PM format
function formatTime24to12(time24) {
    var [hours, minutes] = time24.split(':');
    var period = 'AM';

    hours = parseInt(hours, 10);
    if (hours >= 12) {
        period = 'PM';
    }
    if (hours > 12) {
        hours -= 12;
    }
    if (hours === 0) {
        hours = 12;
    }

    return `${hours}:${minutes} ${period}`;
}

// Fetch and display lecture details
function fetchLectureDetails() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'php/fetch_lecture_details.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            try {
                var response = JSON.parse(xhr.responseText);

                // Check if the response is an array
                if (Array.isArray(response)) {
                    if (response.length === 0) {
                        document.getElementById('lecture-details').innerHTML = '<p>No upcoming lectures found.</p>';
                    } else {
                        // Display lecture details
                        displayLectureDetails(response);
                    }
                } else {
                    console.error('Unexpected data format received:', response);
                    document.getElementById('lecture-details').innerHTML = '<p>Unexpected data format received.</p>';
                }
            } catch (e) {
                console.error('Failed to parse JSON response:', e);
            }
        } else {
            console.error('Failed to fetch lecture details. Status:', xhr.status);
        }
    };
    xhr.send();
}

// Display the lecture details in the live lectures section
function displayLectureDetails(lectures) {
    var detailsContainer = document.getElementById('lecture-details');
    detailsContainer.innerHTML = ''; // Clear existing content

    if (!Array.isArray(lectures)) {
        detailsContainer.innerHTML = '<p>Unexpected data format received.</p>';
        console.error('Expected an array but received:', lectures);
        return;
    }

    // Create HTML for each lecture
    var lecturesHtml = lectures.map(function(lecture) {
        // Convert time to 12-hour AM/PM format
        var formattedTime = formatTime24to12(lecture.time);

        return `
            <div class="lecture-detail">
                <p><strong>Title:</strong> ${lecture.title}</p>
                <p><strong>Date:</strong> ${lecture.date}</p>
                <p><strong>Time:</strong> ${formattedTime}</p>
                <p><a href="${lecture.link}" target="_blank" class="join-btn">Click here to join</a></p>
            </div>
        `;
    }).join(''); // Join all the HTML strings together

    detailsContainer.innerHTML = lecturesHtml;
}

// Other existing functions (e.g., toggleMenu, showEditInfo, etc.) should be included here as well


// Fetch and display PDF files
function fetchPDFFiles() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'php/fetch_pdf_files.php', true); // Adjust this path as needed
    xhr.onload = function() {
        if (xhr.status === 200) {
            try {
                var response = JSON.parse(xhr.responseText);
                console.log('Response received:', response); // Debugging: Log the response

                // Check if the response is an array
                if (Array.isArray(response)) {
                    if (response.length === 0) {
                        document.getElementById('pdf-files-list').innerHTML = '<p>No PDF files found.</p>';
                    } else {
                        displayPDFFiles(response);
                    }
                } else {
                    console.error('Unexpected data format received:', response);
                    document.getElementById('pdf-files-list').innerHTML = '<p>Unexpected data format received.</p>';
                }
            } catch (e) {
                console.error('Failed to parse JSON response:', e);
                document.getElementById('pdf-files-list').innerHTML = '<p>Error processing PDF files.</p>';
            }
        } else {
            console.error('Failed to fetch PDF files. Status:', xhr.status);
            document.getElementById('pdf-files-list').innerHTML = '<p>Error fetching PDF files.</p>';
        }
    };
    xhr.send();
}

// Display the PDF files in the pdf-files-section
function displayPDFFiles(pdfs) {
    var pdfListContainer = document.getElementById('pdf-files-list');
    pdfListContainer.innerHTML = ''; // Clear existing content

    if (!Array.isArray(pdfs)) {
        pdfListContainer.innerHTML = '<p>Unexpected data format received.</p>';
        console.error('Expected an array but received:', pdfs);
        return;
    }

    // Create HTML for each PDF
    var pdfHtml = pdfs.map(function(pdf) {
        return `
            <div class="pdf-file">
                <p><strong>Title:</strong> ${pdf.title}</p>
                <p><a href="${pdf.url}" target="_blank" class="download-btn">Download PDF</a></p>
            </div>
        `;
    }).join(''); // Join all the HTML strings together

    pdfListContainer.innerHTML = pdfHtml;
}

// Fetch PDF files when the PDF files section is shown
function showPDFFiles() {
    hideAllSections();
    document.getElementById('pdf-files-section').style.display = 'block';
    fetchPDFFiles(); // Fetch PDF files when showing this section
}


// Ensure live lectures section fetches data
function showLiveLectures() {
    hideAllSections();
    document.getElementById('live-lectures-section').style.display = 'block';
    fetchLectureDetails();
}


// Fetch and display user details
function fetchUserDetails() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'php/fetch_user_details.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            try {
                var response = JSON.parse(xhr.responseText);

                if (response.error) {
                    document.getElementById('user-info').innerHTML = '<p>' + response.error + '</p>';
                } else {
                    // Display user details
                    var userHtml = `
                        <p><i class="fas fa-user"></i> <strong>Username:</strong> ${response.username}</p>
                        <p><i class="fa-solid fa-graduation-cap"></i> <strong>School:</strong> ${response.school}</p>
                        <p><i class="fas fa-mobile-alt"></i> <strong>Mobile Number:</strong> ${response.mobile_number}</p>
                        <p><i class="fas fa-home"></i> <strong>Address:</strong> ${response.address}</p>
                    `;
                    document.getElementById('user-info').innerHTML = userHtml;
                }
            } catch (e) {
                console.error('Failed to parse JSON response:', e);
            }
        } else {
            console.error('Failed to fetch user details. Status:', xhr.status);
        }
    };
    xhr.send();
}

// Call fetchUserDetails() when the page loads
window.onload = function() {
    fetchUserDetails();
};
