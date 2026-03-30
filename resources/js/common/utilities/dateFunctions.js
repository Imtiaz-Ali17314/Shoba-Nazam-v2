const funcDate = {
    convertUTCToLocalTime(utcTimeString) {
        const utcDate = new Date(utcTimeString.replace(" ", "T") + "Z");
        const localDate = new Date(
            utcDate.getTime() - utcDate.getTimezoneOffset() * 60000
        );
        return localDate.toISOString().replace("T", " ").split(".")[0];
    },

    convertLocalTimeToUTC(localTimeString) {
        const localDate = new Date(localTimeString);
        const utcDate = new Date(localDate.toISOString());
        return utcDate.toISOString().replace("T", " ").split(".")[0];
    },
    formatHours(data) {
        let hours = Math.floor(data / 60);
        let minutes = data % 60;
        let formattedMinutes = minutes.toString().padStart(2, "0");
        return `${hours}:${formattedMinutes}`;
    },

    convertTo24Hour(timeStr) {
        const [time, modifier] = timeStr.split(" ");
        let [hours, minutes] = time.split(":").map(Number);
        if (modifier === "PM" && hours !== 12) {
            hours += 12;
        }
        if (modifier === "AM" && hours === 12) {
            hours = 0;
        }
        return `${String(hours).padStart(2, "0")}:${String(minutes).padStart(
            2,
            "0"
        )}`;
    },

    convertTo12Hour(timeStr) {
        let [hours, minutes] = timeStr.split(":").map(Number);
        const period = hours >= 12 ? "PM" : "AM";
        hours = hours % 12 || 12;
        return `${String(hours)}:${String(minutes).padStart(2, "0")} ${period}`;
    },
    convertUTCToLocalTime(utcTimeString) {
        const [hours, minutes] = utcTimeString.split(":").map(Number);
        const utcDate = new Date();
        utcDate.setUTCHours(hours, minutes, 0, 0);
        const localTime = utcDate.toLocaleTimeString([], {
            hour: "2-digit",
            minute: "2-digit",
            hour12: true,
        });
        return localTime;
    },



    getToday() {
        const today = new Date();
        const dayOfWeek = today.getDay();
        const daysOfWeek = [
            "Sunday",
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
            "Saturday",
        ];
        return daysOfWeek[dayOfWeek];
    },
    getPastDates(count = 4) {
        const formatDate = (date) => date.toISOString().split("T")[0];
        const result = [];
        for (let i = count - 1; i >= 0; i--) {
            const d = new Date();
            d.setDate(d.getDate() - i);
            result.push(formatDate(d));
        }
        return result; // e.g. ['2025-05-24', '2025-05-25', '2025-05-26', '2025-05-27']
    },
};
export { funcDate };

export function formatTime(utcTimeString) {
    const [date, time] = utcTimeString.split(" ");
    const [hours, minutes, seconds] = time.split(":").map(Number);
    const utcDate = new Date();
    utcDate.setUTCHours(hours, minutes, seconds, 0);
    const localTime = utcDate.toLocaleTimeString([], {
        hour: "2-digit",
        minute: "2-digit",
        hour12: true,
    });
    return localTime;
}

export function formatHours(data) {
    const hours = Math.floor(data / 60);
    const minutes = data % 60;
    if (hours === 0) {
        return `${minutes} minutes`;
    } else if (minutes === 0) {
        return `${hours} hours`;
    } else {
        return `${hours}h ${minutes}m`;
    }
}

export function convertLocalTimeToUTC(localTimeString) {
    const localDate = new Date(localTimeString);
    const utcDate = new Date(localDate.toISOString());
    return utcDate.toISOString().replace("T", " ").split(".")[0];
}

export function getUTCTimeRangeQuery(date) {
    let url;
    if (date) {
        if (date.includes(" to ")) {
            let [startDate, endDate] = date.split(" to ");
            let StartTime = convertLocalTimeToUTC(startDate + " 00:00:00");
            let endTime = convertLocalTimeToUTC(endDate + " 23:59:59");
            url = `?start=${StartTime}&end=${endTime}`;
        } else {
            let StartTime = convertLocalTimeToUTC(date + " 00:00:00");
            let endTime = convertLocalTimeToUTC(date + " 23:59:59");
            url = `?start=${StartTime}&end=${endTime}`;
        }
    } else {
        let currentDate = new Date();
        let currentDay = `${currentDate.getFullYear()}-${String(
            currentDate.getMonth() + 1
        ).padStart(2, "0")}-${String(currentDate.getDate()).padStart(2, "0")}`;
        let StartTime = convertLocalTimeToUTC(currentDay + " 00:00:00");
        let endTime = convertLocalTimeToUTC(currentDay + " 23:59:59");
        url = `?start=${StartTime}&end=${endTime}`;
    }

    return url;
}
export function calculateHours(data) {
    if (!data) return "0:00";
    let total_time = 0;
    for (const item of data) {
        total_time += item.interval_time;
    }
    return funcDate.formatHours(total_time);
}

export function getIntervalMinutes(data) {
    const start = data.start_time;
    const end = data.end_time;
    const startTime = new Date(start);
    const endTime = new Date(end);
    const diffMs = endTime - startTime;
    const diffMinutes = Math.floor(diffMs / 60000);
    return diffMinutes;
}

export const generateCustomDateRange = (month = null, year = null) => {
    const today = new Date();
    let startDate, endDate;
    const formatDate = (date) => {
        const y = date.getFullYear();
        const m = String(date.getMonth() + 1).padStart(2, "0");
        const d = String(date.getDate()).padStart(2, "0");
        return `${y}-${m}-${d}`;
    };
    if (month === null || month === undefined) {
        const firstOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
        startDate = formatDate(firstOfMonth);
        endDate = formatDate(today);
    } else {
        const targetYear = year !== null && year !== undefined ? parseInt(year) : today.getFullYear();
        const targetMonth = parseInt(month);
        const prevMonth = targetMonth - 1;
        const prevMonthStart = new Date(targetYear, prevMonth - 1, 1);
        const nextMonth = targetMonth + 1;
        const nextMonthEnd = new Date(targetYear, nextMonth, 0);
        startDate = formatDate(prevMonthStart);
        endDate = formatDate(nextMonthEnd);
    }
    return {
        start_date: startDate,
        end_date: endDate,
        offset: generateTimezoneOffset(),
    };
};

const generateTimezoneOffset = () => {
    const offsetMinutes = new Date().getTimezoneOffset();
    const timezoneOffset = -offsetMinutes / 60;
    return timezoneOffset;
};

export function formatMonth(input) {
    const date = new Date(input);
    const options = { year: "numeric", month: "short", day: "numeric" };
    return date.toLocaleDateString("en-US", options);
}

export function isWithinPreviousDays(dateString, daysNum) {
    if (!dateString || !daysNum) return false;
    const inputDate = new Date(dateString);
    const today = new Date();
    inputDate.setHours(0, 0, 0, 0);
    today.setHours(0, 0, 0, 0);
    const diffInMs = today - inputDate;
    const diffInDays = diffInMs / (1000 * 60 * 60 * 24);
    return diffInDays >= 0 && diffInDays <= daysNum;
}

export function getTimezone() {
    return Intl.DateTimeFormat().resolvedOptions().timeZone;
}


export function utcToLocalDate(utcString) {
    const utcIso = utcString.replace(" ", "T") + "Z";
    const date = new Date(utcIso);
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, "0");
    const day = String(date.getDate()).padStart(2, "0");
    return `${year}-${month}-${day}`;
}
