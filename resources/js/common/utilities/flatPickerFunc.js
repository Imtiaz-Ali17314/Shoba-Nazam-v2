const calc = {

    customBtn(instance) {
        const calendarContainer = instance.calendarContainer;
        const customBtnContainer = document.createElement("div");
        customBtnContainer.className = "mb-2";
        customBtnContainer.innerHTML = `
                <div class='gap-1 d-flex flex-wrap justify-content-center'>
                    <div class="btn-group mb-3 mb-md-0" role="group" aria-label="Basic example">
                      <button type="button" id="btn-this-week" class="btn btn-outline-secondary">This Week</button>
                      <button type="button" id="btn-last-15-days" class="btn btn-outline-secondary  d-md-block">Last 15 Days</button>
                      <button type="button" id="btn-this-month" class="btn btn-outline-secondary">This Month</button>
                      </div>
                </div>
            `;

        calendarContainer.appendChild(customBtnContainer);
        const handleButtonClick = (buttonId, startDate, endDate) => {
            document.getElementById(buttonId).addEventListener("click", () => {
                instance.setDate([startDate, endDate]);
                instance.close();
            });
        };
        const today = new Date();
        const startOfWeek = new Date(today);
        const dayOfWeek = today.getDay();
        const distanceToMonday = (dayOfWeek === 0 ? -6 : 1) - dayOfWeek;
        startOfWeek.setDate(today.getDate() + distanceToMonday);
        const endOfWeek = new Date(startOfWeek);
        endOfWeek.setDate(startOfWeek.getDate() + 6);
        const last15DaysEnd = new Date();
        const last15DaysStart = new Date(last15DaysEnd);
        last15DaysStart.setDate(last15DaysEnd.getDate() - 14);
        const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
        const endOfMonth = new Date(
            today.getFullYear(),
            today.getMonth() + 1,
            0
        );
        handleButtonClick("btn-this-week", startOfWeek, endOfWeek);
        handleButtonClick("btn-last-15-days", last15DaysStart, last15DaysEnd);
        handleButtonClick("btn-this-month", startOfMonth, endOfMonth);
    },


};

export { calc };
