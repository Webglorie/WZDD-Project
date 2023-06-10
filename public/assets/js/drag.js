const draggables = document.querySelectorAll(".task");
const droppables = document.querySelectorAll(".swim-lane");

draggables.forEach((task) => {
  task.addEventListener("dragstart", () => {
    task.classList.add("is-dragging");
    console.log("test");
  });
  task.addEventListener("dragend", () => {
    task.classList.remove("is-dragging");
  });
});
draggedCards.forEach((task) => {
    task.addEventListener("dragend", () => {
        const newCategoryId = task.closest('.attendance-category-block').dataset.attendancecatid;
        const oldCategoryId = task.dataset.catid;

        // Bijwerken van data-catid van de card
        task.dataset.catid = newCategoryId;

        // Uitvoeren van de console-log
        console.log('Succes: oude catid = ' + oldCategoryId + ' en nieuwe is = ' + newCategoryId);
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
});

draggables.forEach((task) => {
    task.addEventListener("dragend", () => {
        const newCategoryId = task.closest('.attendance-category-block').dataset.attendancecatid;
        const oldCategoryId = task.dataset.catid;

        // Bijwerken van data-catid van de card
        task.dataset.catid = newCategoryId;

        // Uitvoeren van de console-log
        console.log('Succes: oude catid = ' + oldCategoryId + ' en nieuwe is = ' + newCategoryId);
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
