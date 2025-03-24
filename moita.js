document.addEventListener("DOMContentLoaded", function () {
  // Toggle "Read More" functionality
  window.toggleText = function (id) {
    const element = document.getElementById(id);
    element.style.display =
      element.style.display === "none" || element.style.display === ""
        ? "block"
        : "none";
  };

  // Enable inline editing of table rows
  window.makeEditable = function (row) {
    const cells = row.querySelectorAll('[data-editable="true"]');
    cells.forEach(cell => {
      cell.contentEditable = "true";
      cell.style.backgroundColor = "#f4f4f4"; // highlight editable cells
    });
    row.querySelector('.edit-btn').style.display = "none";
    row.querySelector('.save-btn').style.display = "inline-block";
  };

  window.saveChanges = function (row, id) {
    const cells = row.querySelectorAll('[data-editable="true"]');
    let updates = {};
    cells.forEach(cell => {
      const field = cell.getAttribute('data-field');
      const value = cell.textContent.trim();
      updates[field] = value;
    });
    console.log("Saving changes for id", id, updates);

    // Remove editing attributes
    cells.forEach(cell => {
      cell.contentEditable = "false";
      cell.style.backgroundColor = "";
    });
    row.querySelector('.edit-btn').style.display = "inline-block";
    row.querySelector('.save-btn').style.display = "none";
  };

  // Animate directors when scrolled into view
  if ('IntersectionObserver' in window) {
    const directors = document.querySelectorAll('.director');
    const observerOptions = { threshold: 0.5 };
    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('animate');
          obs.unobserve(entry.target);
        }
      });
    }, observerOptions);
    directors.forEach(director => observer.observe(director));
  } else {
    const directors = document.querySelectorAll('.director');
    directors.forEach(director => director.classList.add('animate'));
  }

  // Set Active Menu Item Based on URL
  const menuLinks = document.querySelectorAll('.menu-item > a');

  menuLinks.forEach(link => {
    link.addEventListener('click', function (e) {
      let submenu = this.nextElementSibling;
      if (submenu && submenu.classList.contains('submenu')) {
        e.preventDefault();
        submenu.style.display = submenu.style.display === "block" ? "none" : "block";
      }
    });
  });

  // Slideshow functionality
  let slideIndex = 0;
  function showSlides() {
    const slides = document.querySelectorAll(".slideshow-container img");
    slides.forEach(slide => slide.style.display = "none");
    slideIndex = (slideIndex + 1) % slides.length;
    slides[slideIndex].style.display = "block";
  }

  if (document.querySelector(".slideshow-container")) {
    setInterval(showSlides, 3000);
  }
  //MPESA intergration
  document.getElementById('mpesa-repay').addEventListener('click', function () {
    const phoneNumber = prompt('Enter your M-Pesa phone number:');
    const amount = prompt('Enter the repayment amount:');

    if (phoneNumber && amount) {
      fetch('repayment.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ phone: phoneNumber, amount: amount }), // Send data as JSON
      })
        .then(response => response.json())
        .then(data => {
          if (data.ResponseCode === '0') {
            alert('Payment initiated. Please complete the payment on your phone.');
          } else {
            alert('Payment failed: ' + (data.errorMessage || data.error));
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred. Please try again.');
        });
    } else {
      alert('Phone number and amount are required.');
    }
  });

});
