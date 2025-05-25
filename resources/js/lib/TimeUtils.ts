export type BookedRange = {
    start: string;
    end: string;
};

/**
 * Converts a time string in "HH:MM" format into an object with separate hours and minutes.
 *
 * @param dateString - The time string to convert, formatted as "HH:MM".
 * @returns An object containing the hours and minutes as numbers.
 */
export function toTime(dateString: string) {
    const [hours, minutes] = dateString.split(':').map(Number);
    return { hours, minutes };
}

/**
 * Determines if a given time conflicts with any of the specified booked time ranges.
 *
 * @param time - The time to check for conflicts, formatted as "HH:MM".
 * @param ranges - An array of booked time ranges, each with a start and end time.
 * @returns A boolean indicating whether the time conflicts with any of the booked ranges.
 */
export function isTimeConflicting(time: string, ranges: BookedRange[]) {
    const timeObj = toTime(time);

    return ranges.some(({ start, end }) => {
        const startObj = toTime(start);
        const endObj = toTime(end);

        if (timeObj.hours === startObj.hours && timeObj.hours === endObj.hours) {
            return timeObj.minutes >= startObj.minutes && timeObj.minutes < endObj.minutes;
        }

        if (timeObj.hours === startObj.hours) {
            return timeObj.minutes >= startObj.minutes;
        }

        if (timeObj.hours === endObj.hours) {
            return timeObj.minutes < endObj.minutes;
        }

        return (timeObj.hours > startObj.hours && timeObj.hours < endObj.hours) ||
            (timeObj.hours === startObj.hours && timeObj.minutes >= startObj.minutes) ||
            (timeObj.hours === endObj.hours && timeObj.minutes <= endObj.minutes);
    });
}

/**
 * Filters out times that conflict with any booked time ranges.
 *
 * @param times - An array of time strings to be checked for conflicts.
 * @param bookedRanges - An object containing a value property, which is an array of booked time ranges.
 * @returns An array of time strings that do not conflict with any of the booked time ranges.
 */
export function removeConflictingTimes(times: string[], bookedRanges: { value: BookedRange[] }) {
    let data = []
    data = times.filter((time) => {
        return !isTimeConflicting(time, bookedRanges.value);
    });

    return data
}

/**
 * Filters and returns a list of valid end times from a given list of times,
 * based on the specified booking start time and existing booked ranges.
 *
 * @param times - An array of time strings in 'hh:mm' format representing potential end times.
 * @param bookIn - A Date object representing the start time of the booking.
 * @param bookedRanges - An array of BookedRange objects indicating existing booked time ranges.
 * @returns An array of valid end times in 'hh:mm' format, sorted and without duplicates.
 */
export function getValidEndTimes(
    times: string[],
    bookIn: Date,
    bookedRanges: { start: string; end: string }[]
): string[] {
    const bookInTime = `${bookIn.getHours()}:${bookIn.getMinutes().toString().padStart(2, '0')}`;
    const bookInObj = toTime(bookInTime);

    const sortedBookedRanges = [...bookedRanges].sort((a, b) => {
        const timeA = toTime(a.start);
        const timeB = toTime(b.start);
        return timeA.hours - timeB.hours || timeA.minutes - timeB.minutes;
    });

    const firstBookedRangeAfterBookIn = sortedBookedRanges.find(({ start }) => {
        const startObj = toTime(start);
        return startObj.hours > bookInObj.hours ||
            (startObj.hours === bookInObj.hours && startObj.minutes > bookInObj.minutes);
    });

    if (!firstBookedRangeAfterBookIn) {
        return times.filter((time) => {
            const timeObj = toTime(time);
            return (
                timeObj.hours > bookInObj.hours ||
                (timeObj.hours === bookInObj.hours && timeObj.minutes >= bookInObj.minutes)
            );
        });
    }
    // console.log('firstBookedRangeAfterBookIn', firstBookedRangeAfterBookIn, 'ranges', sortedBookedRanges);

    const firstRangeStartObj = toTime(firstBookedRangeAfterBookIn.start);

    const validTimes = times.filter((time) => {

        const timeObj = toTime(time);
        return (
            (timeObj.hours > bookInObj.hours ||
                (timeObj.hours === bookInObj.hours && timeObj.minutes >= bookInObj.minutes)) &&
            (timeObj.hours < firstRangeStartObj.hours ||
                (timeObj.hours === firstRangeStartObj.hours && timeObj.minutes < firstRangeStartObj.minutes))
        );
    });

    if (!validTimes.includes(firstBookedRangeAfterBookIn.start)) {
        validTimes.push(firstBookedRangeAfterBookIn.start);
    }

    return validTimes;
}


export const formatDate = (dateString: string, time: boolean = false): string => {
    const date = new Date(dateString);

    const day = String(date.getDate()).padStart(2, "0");
    const month = String(date.getMonth() + 1).padStart(2, "0");
    const year = date.getFullYear();
    const formattedDate = `${day}/${month}/${year}`;

    if (time) {
        const hours = date.getHours();
        const minutes = String(date.getMinutes()).padStart(2, "0");
        const period = hours >= 12 ? "PM" : "AM";
        const formattedHours = String(hours % 12 || 12);
        const formattedTime = `${formattedHours}:${minutes} ${period}`;

        return `${formattedDate} ${formattedTime}`;
    }

    return formattedDate;
};

export function makeFarsi(dateString: string, time: boolean = false) {
    const date = new Date(dateString);
    let options: Intl.DateTimeFormatOptions;

    if (time) {
        options = {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            weekday: 'long'
        };
    } else {
        options = {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            weekday: 'long'
        };
    }

    const formatter = new Intl.DateTimeFormat('fa-IR', options);
    return formatter.format(date);

};

export function getHourSection(dateString: string) {
    const date = new Date(dateString);
    const timeOptions: Intl.DateTimeFormatOptions = {
        hour: 'numeric',
        minute: 'numeric'
    };

    const formatter = new Intl.DateTimeFormat('fa-IR', timeOptions);
    return formatter.format(date);
}


export const handleConvertMiliSecondsToHour = (bookIn: string, bookOut: string) => {

    const startDate = new Date(bookIn);
    const endDate = new Date(bookOut);
    const diffInMs = endDate.getTime() - startDate.getTime();

    const hours = Math.floor(diffInMs / (1000 * 60 * 60));
    const minutes = Math.floor((diffInMs % (1000 * 60 * 60)) / (1000 * 60));
    return `${hours} : ${minutes}`;
};

export const getDiffTime = ( bookOut: string) => {
    const startDate = new Date();
    const endDate = new Date(bookOut);
    const diffInMs = endDate.getTime() - startDate.getTime();
    return diffInMs;
}