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
            const attendanceCatBlock = draggedTask.closest(".attendance-category-block");

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
