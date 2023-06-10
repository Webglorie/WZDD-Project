const draggables = document.querySelectorAll(".task");
const droppables = document.querySelectorAll(".swim-lane");

draggables.forEach((task) => {
    task.addEventListener("dragstart", () => {
        task.classList.add("is-dragging");
    });
    task.addEventListener("dragend", () => {
        task.classList.remove("is-dragging");
    });
});
// Definieer een lege array
var draggedCards = [];

// Voeg de draggable elementen toe aan de array
$('.task').each(function() {
    draggedCards.push(this);
});

draggedCards.forEach((task) => {
    task.addEventListener("dragend", () => {
        const newCategoryId = $(task).closest('.attendance-category-block').attr('data-attendancecatid');
        const oldCategoryId = $(task).attr('data-catid');
        const attendanceId = $(task).attr('data-attendanceid');

        // Bepaal het dayOfWeek nummer (1-5 voor maandag-vrijdag, 1 voor zaterdag/zondag)
        const currentDay = new Date().getDay();
        let dayOfWeek;

        if (currentDay === 0 || currentDay === 6) {
            dayOfWeek = 1;
        } else {
            dayOfWeek = currentDay;
        }

        // API-aanroep om de categorie-ID bij te werken op basis van de dag van de week
        $.ajax({
            url: '/api/attendance/update-category/' + dayOfWeek + '/' + attendanceId + '/' + newCategoryId,
            type: 'PUT',
            success: function(response) {
                console.log(response.message);
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseJSON.message);
            }
        });
    });
});

droppables.forEach((zone) => {
    zone.addEventListener("dragover", (e) => {
        e.preventDefault();

        const bottomTask = insertAboveTask(zone, e.clientY);
        const curTask = document.querySelector(".is-dragging");

        if (!bottomTask) {
            zone.appendChild(curTask);
        } else {
            zone.insertBefore(curTask, bottomTask);
        }
    });

    zone.addEventListener("drop", (e) => {
        const targetLane = e.target.closest(".swim-lane");

        if (targetLane) {
            const targetLaneId = targetLane.getAttribute("id");
            const draggedTask = document.querySelector(".is-dragging");
            const attendanceCatBlock = draggedTask.closest(".attendance-categories-block");

            if (attendanceCatBlock) {
                const attendanceCatId = attendanceCatBlock.getAttribute("id").replace("attendance-cat-", "");
                const attendanceId = draggedTask.getAttribute("data-attendanceid");

                console.log("Target Lane ID:", targetLaneId);
                console.log("Attendance Category ID:", attendanceCatId);
                console.log("Dragged Task Attendance ID:", attendanceId);

                // Stuur gegevens via PUT-verzoek naar de API
                const apiUrl = `http://127.0.0.1:8000/api/attendances/${attendanceCatId}/${attendanceId}/`;
                fetch(apiUrl, {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        // Voeg eventuele extra gegevens toe die je wilt bijwerken
                    }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        // Verwerk de API-respons indien nodig
                        console.log("PUT Request Response:", data);
                    })
                    .catch((error) => {
                        // Verwerk eventuele fouten bij het uitvoeren van het PUT-verzoek
                        console.error("Error:", error);
                    });
            }

            // Voer hier verdere acties uit op basis van de verplaatste taak en de doellane
        }
    });
});

const insertAboveTask = (zone, mouseY) => {
    const els = zone.querySelectorAll(".task:not(.is-dragging)");

    let closestTask = null;
    let closestOffset = Number.NEGATIVE_INFINITY;

    els.forEach((task) => {
        const { top } = task.getBoundingClientRect();

        const offset = mouseY - top;

        if (offset < 0 && offset > closestOffset) {
            closestOffset = offset;
            closestTask = task;
        }
    });

    return closestTask;
};
