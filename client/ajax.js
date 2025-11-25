document.addEventListener("DOMContentLoaded", function() {
    const floorDropdown = document.querySelector('.dropdown-content[data-name="floor"]');
    const apartmentDropdown = document.querySelector('.dropdown-content[data-name="apartment"]');

    // Use event delegation on the building dropdown container for dynamically added items (MODIFIED)
    const buildingDropdownContent = document.querySelector('.dropdown-content[data-name="building"]');
    const buildingInputField = document.querySelector('input[name="buildingName"]');

    // Listener for clicks on building items (Delegated)
    buildingDropdownContent.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('dropdown-item') && e.target.getAttribute('data-name') === 'building') {
            const item = e.target;
            const selectedBuilding = item.textContent.trim(); // Get building name
            const buildingId = item.getAttribute('data-id'); // Get building ID
            
            console.log("Selected Building: " + selectedBuilding); // Log the building name
            console.log("Building ID: " + buildingId); // Log the building ID
            
            // 1. Update the Building Name input field and close the dropdown
            buildingInputField.value = selectedBuilding;
            buildingDropdownContent.style.display = 'none';

            // 2. Clear Floor/Apartment inputs/dropdowns before fetching new data (Cleanup)
            document.querySelector('input[name="floor"]').value = '';
            document.querySelector('input[name="apartment"]').value = '';
            floorDropdown.innerHTML = '';
            apartmentDropdown.innerHTML = '';

            // 3. Send the selected building ID to the PHP script via AJAX
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
                data.floors.forEach(floor => {
                    const div = document.createElement('div');
                    div.classList.add('dropdown-item');
                    div.setAttribute('data-name', 'floor');
                    div.textContent = floor; // Set floor name
                    floorDropdown.appendChild(div);
                });

                // Populate the apartment dropdown
                data.apartments.forEach(apartment => {
                    const div = document.createElement('div');
                    div.classList.add('dropdown-item');
                    div.setAttribute('data-name', 'apartment');
                    div.textContent = apartment; // Set apartment name
                    apartmentDropdown.appendChild(div);
                });
            })
            .catch(error => console.error('Error fetching building details:', error));
            
            e.stopPropagation(); // Stop event bubbling
        }
    });

    // Handle click on floor and apartment items and update input fields (Existing logic)
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