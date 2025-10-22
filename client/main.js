// JavaScript to detect when the element comes into view
const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            // When the element comes into view, add the 'slide-in' class
            entry.target.classList.add('slide-in');
            observer.unobserve(entry.target); // Stop observing after the animation is triggered
        }
    });
}, { threshold: 0.2 }); // Trigger when 50% of the element is in view

// Target the .report-issue element
const reportIssue = document.querySelector('.report-issue');
observer.observe(reportIssue);
