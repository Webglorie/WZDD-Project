
var notifications = [];

var currentIndex = 0;

function showNotification() {
    var currentNotification = notifications[currentIndex];

    var titleElement = document.getElementById("notificationTitle");
    var textElement = document.getElementById("notificationText");
    var countElement = document.getElementById("notificationCount");

    if (titleElement && textElement && countElement) {
        titleElement.innerHTML = currentNotification.title;
        textElement.innerHTML = currentNotification.description;

        var notificationCountText = "-- Melding " + (currentIndex + 1) + "/" + notifications.length + " --";
        countElement.textContent = notificationCountText;

        currentIndex = (currentIndex + 1) % notifications.length; // Volgende melding index
    }

    setTimeout(showNotification, 10000); // Wacht 10 seconden en toon de volgende melding
}




$(document).ready(function() {
    splitListItems();
    console.log("testttttt");

    function splitListItems() {
        setTimeout(function() {
            var listGroup = $(".beschikbare-laptops");
            var items = listGroup.children(".list-group-item");

            if (items.length > 5) {
                var splitIndex = Math.ceil(items.length / 2);

                var leftItems = items.slice(0, splitIndex);
                var rightItems = items.slice(splitIndex);

                listGroup.empty();

                var rowContainer = $("<div>").addClass("row");
                var leftColumn = $("<div>").addClass("col-md-6");
                var rightColumn = $("<div>").addClass("col-md-6");

                leftItems.appendTo(leftColumn);
                rightItems.appendTo(rightColumn);

                rowContainer.append(leftColumn);
                rowContainer.append(rightColumn);
                listGroup.append(rowContainer);
            }
        }, 2000); // 10 seconden
    }



    function fetchProblems() {
        $.ajax({
            url: 'http://127.0.0.1:8000/api/problems',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var problems = response;
                var tbody = $('#problems-table tbody');

                tbody.empty();

                $.each(problems, function(index, problem) {
                    var row = $('<tr>');
                    row.append($('<td>').text(problem.problem_number));
                    row.append($('<td>').html(problem.description)); // Gebruik .html() om de HTML-inhoud in te voegen
                    tbody.append(row);
                });
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }


    // Roep de functie fetchProblems direct aan
    fetchProblems();

    // Roep de functie fetchProblems elke 120 seconden aan
    setInterval(fetchProblems, 120000);

    function fetchNotifications() {
        $.ajax({
            url: 'http://127.0.0.1:8000/api/notifications', // De URL van de API om de meldingen op te halen
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                notifications = response; // Vervang de meldingen met de ontvangen JSON-gegevens
                console.log("Notifications refreshed:", notifications);
                showNotification();
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText); // Toon foutinformatie in de console
            }
        });
    }

    // Roep de functie fetchNotifications direct aan
    fetchNotifications();

    // Roep de functie fetchNotifications elke 120 seconden aan
    setInterval(fetchNotifications, 120000);


    function fetchBorrowedEquipments() {
        $.ajax({
            url: 'http://127.0.0.1:8000/api/borrowed-equipments/Leenlaptop',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                populateTable(response);
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    function populateTable(borrowedEquipments) {
        var tbody = $('#borrowed-equipment-table tbody');
        tbody.empty();

        $.each(borrowedEquipments, function(index, borrowedEquipment) {
            var borrowedDateBegin = new Date(borrowedEquipment.borrowed_date_begin).toLocaleDateString();
            var borrowedDateEnd = new Date(borrowedEquipment.borrowed_date_end).toLocaleDateString();

            var row = $('<tr>');
            row.append($('<td>').text(borrowedEquipment.equipment_title));
            row.append($('<td>').text(borrowedEquipment.ultimo_ticket_number));
            row.append($('<td>').text(borrowedDateBegin + ' tot ' + borrowedDateEnd));
            tbody.append(row);
        });
    }

    fetchBorrowedEquipments();




    function getEquipment() {
        $.ajax({
            url: 'http://127.0.0.1:8000/api/equipment/1/available',
            dataType: 'json',
            success: function(response) {
                var listGroup = $('.list-group.beschikbare-laptops');
                listGroup.empty(); // Leegmaken van de list-group

                // Loop door de equipment in de JSON-respons en voeg de titles toe aan de list-group
                $.each(response, function(index, equipment) {
                    var listItem = $('<div class="list-group-item list-group-item-action"></div>').text(equipment.title);
                    listGroup.append(listItem);
                });
                splitListItems();
            },
            error: function() {
                console.log('Er is een fout opgetreden bij het ophalen van de equipment.');
            }
        });
    }

    // Initial call om de equipment op te halen
    getEquipment();

    // Timer om de equipment elke 120 seconden op te halen
    setInterval(getEquipment, 120000);

    function getAgendaItems() {
        $.ajax({
            url: 'http://127.0.0.1:8000/api/agenda-items',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var listGroup = $('.list-group.agendaitems');
                listGroup.empty(); // Leegmaken van de list-group

                if (response.length === 0) {
                    var emptyMessage = '<div class="list-group-item">Er zijn geen agendapunten gevonden.</div>';
                    listGroup.append(emptyMessage);
                } else {
                    var sortedItems = []; // Tijdelijke array voor gesorteerde items

                    // Loop door de ontvangen AgendaItems en voeg ze toe aan de tijdelijke array
                    $.each(response, function(index, item) {
                        sortedItems.push(item);
                    });

                    // Sorteer de tijdelijke array op basis van de tijd (van dichtbij naar ver weg)
                    sortedItems.sort(function(a, b) {
                        var timeA = new Date(a.time).getTime();
                        var timeB = new Date(b.time).getTime();
                        return timeA - timeB;
                    });

                    var itemCount = 0; // Teller voor bijgehouden items

                    // Loop door de gesorteerde AgendaItems en bouw de HTML
                    $.each(sortedItems, function(index, item) {
                        if (itemCount >= 3) {
                            return false; // Stop de lus zodra er 3 items zijn toegevoegd
                        }

                        var html = '<div class="list-group-item list-group-item-action status-' + item.status + '">' +
                            '<b>' + item.time + ' - ' + item.status + ' - ' + item.remainingTime + '</b> - ' + item.location + ' - ' + item.description +
                            '</div>';

                        // Voeg de HTML toe aan de list-group
                        listGroup.append(html);

                        itemCount++; // Verhoog de teller
                    });
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }



// Initial call om de equipment op te halen
    getAgendaItems();

    // Timer om de equipment elke 120 seconden op te halen
    setInterval(getAgendaItems, 120000);

});

$(document).ready(function() {
    $.getJSON('http://127.0.0.1:8000/api/attendance-schedules', function(data) {
        $.each(data, function(index, employee) {
            var departmentId = employee.department_id;
            var categoryId = employee.category_id;
            var categoryName = employee.category_name;
            var employeeName = employee.employee_name;

            // Controleer of category_id gelijk is aan 5 en sla de iteratie over als dat het geval is
            if (categoryId != '1') {
                // Zoek de juiste card op basis van department_id
                var cardId = (departmentId === 1) ? '#servicedesk-col' : '#beheer-col';
                var card = $(cardId);

                // Zoek de juiste list-group-item op basis van category_name
                var listItem = card.find('.list-group-item:has(.attendance-title:contains("' + categoryName + '"))');

                // Als er geen bestaande list-group-item is met de attendance-title, maak er dan een nieuwe aan
                if (listItem.length === 0) {
                    listItem = $('<div class="list-group-item list-group-item-action"></div>');
                    var attendanceTitle = $('<div class="attendance-title">' + categoryName + '</div>');
                    var ul = $('<ul></ul>');
                    listItem.append(attendanceTitle, ul);
                    card.find('.list-group').append(listItem);
                }

                // Voeg de naam van de werknemer toe aan de lijst
                var ul = listItem.find('ul');
                ul.append('<li>' + employeeName + '</li>');
            }
        });
    });
});

function getCategoryName(categoryId) {
    // Hier kun je de categorieën en hun bijbehorende ID's definiëren
    // Vervang deze logica door je eigen categorieën en ID's
    switch (categoryId) {
        case '1':
            return 'Aanwezig';
        case '2':
            return 'Thuiswerken';
        // Voeg hier andere categorieën toe
        default:
            return '';
    }
}
