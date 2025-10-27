document.addEventListener("DOMContentLoaded", function() {
    // Get all the dropdown items for buildings
    const buildingItems = document.querySelectorAll('.dropdown-item[data-name="building"]');
    const floorDropdown = document.querySelector('.dropdown-content[data-name="floor"]');
    const apartmentDropdown = document.querySelector('.dropdown-content[data-name="apartment"]');

    // Listen for clicks on building items
    buildingItems.forEach(function(item) {
        item.addEventListener('click', function() {
            const selectedBuilding = item.textContent.trim(); // Get building name
            const buildingId = item.getAttribute('data-id'); // Get building ID
            
            console.log("Selected Building: " + selectedBuilding); // Log the building name
            console.log("Building ID: " + buildingId); // Log the building ID
            document.querySelector('input[name="buildingName"]').value = selectedBuilding;

            // Send the selected building ID to the PHP script via AJAX
            fetch('fetch_building_details.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `building_id=${buildingId}` // Send building ID to PHP script
            })
            .then(response => response.json())
            .then(data => {
                // Populate the floor dropdown
                floorDropdown.innerHTML = ''; // Clear previous options
                data.floors.forEach(floor => {
                    const div = document.createElement('div');
                    div.classList.add('dropdown-item');
                    div.setAttribute('data-name', 'floor');
                    div.textContent = floor; // Set floor name
                    floorDropdown.appendChild(div);
                });

                // Populate the apartment dropdown
                apartmentDropdown.innerHTML = ''; // Clear previous options
                data.apartments.forEach(apartment => {
                    const div = document.createElement('div');
                    div.classList.add('dropdown-item');
                    div.setAttribute('data-name', 'apartment');
                    div.textContent = apartment; // Set apartment name
                    apartmentDropdown.appendChild(div);
                });
            })
            .catch(error => console.error('Error fetching building details:', error));
        });
    });

    // Handle click on floor and apartment items and update input fields
    [floorDropdown, apartmentDropdown].forEach(function(dropdown) {
        dropdown.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('dropdown-item')) {
                const selectedItem = e.target.textContent;
                console.log(`Selected ${e.target.dataset.name}: ${selectedItem}`);

                // Update the input field with the selected floor or apartment
                if (e.target.dataset.name === 'floor') {
                    document.getElementById('floor').value = selectedItem; // Update floor input field
                } else if (e.target.dataset.name === 'apartment') {
                    document.getElementById('apartment').value = selectedItem; // Update apartment input field
                }

                // Optionally close the dropdown after selection
                e.target.closest('.dropdown-content').style.display = 'none'; // Hide the dropdown
            }
        });
    });
});
