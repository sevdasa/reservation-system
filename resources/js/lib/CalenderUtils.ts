// انواع داده برای تابع تبدیل تاریخ میلادی به شمسی
interface JalaliDate {
    jy: number; // سال شمسی
    jm: number; // ماه شمسی
    jd: number; // روز شمسی
}
export const preferences = [
    { label: 'Farsi (Persian)', locale: 'fa-IR', territories: 'IR IR', ordering: 'persian gregory islamic islamic-civil islamic-tbla' },

]

export const calendars = [

    { key: 'persian', name: 'Persian' },

]

export const convertToGregorian = (year: number, month: number, day: number) => {
    // چک کردن اینکه ماه و روز معتبر هستند
    if (month < 1 || month > 12 || day < 1 || day > 31) {
        throw new Error('Invalid date: month must be between 1 and 12, and day must be between 1 and 31.');
    }

    // تعداد روزهای هر ماه در سال شمسی
    const smd = [31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29];

    // محاسبه تعداد روزها از ابتدای سال شمسی
    let days = day - 1;
    for (let i = 0; i < month - 1; i++) {
        days += smd[i];
    }

    // سال کبیسه در تقویم شمسی
    const leap = ((year + 11) % 33) % 4 === 0;

    // اگر سال شمسی کبیسه است و ماه‌های بعد از مهر است، یک روز به تعداد روزها اضافه می‌شود
    if (month > 10 && leap) days += 1;

    // تبدیل سال شمسی به میلادی
    const gy = year + 621; // سال میلادی برابر با سال شمسی + 621
    const gd = new Date(gy, 2, leap ? 20 : 21); // تاریخ مبنای میلادی برابر با 20 یا 21 مارس (با توجه به کبیسه بودن)

    // محاسبه تاریخ میلادی با افزودن تعداد روزها به تاریخ مبنا
    gd.setDate(gd.getDate() + days);

    // استخراج سال، ماه و روز میلادی
    const gregorianYear = gd.getFullYear();
    const gregorianMonth = gd.getMonth() + 1; // ماه میلادی (0-11، بنابراین باید 1 را اضافه کنیم)
    const gregorianDay = gd.getDate();

    // بازگشت تاریخ میلادی به فرمت YYYY-MM-DD
    return `${gregorianYear}-${gregorianMonth.toString().padStart(2, '0')}-${gregorianDay.toString().padStart(2, '0')}`;
};



/**
 * Converts a Gregorian date to a Jalali (Persian) date.
 *
 * @param year - The Gregorian year.
 * @param month - The Gregorian month (1-based, where 1 = January and 12 = December).
 * @param day - The Gregorian day of the month.
 * @returns An object representing the Jalali date with the following properties:
 *          - `jy`: The Jalali year.
 *          - `jm`: The Jalali month (1-based, where 1 = Farvardin and 12 = Esfand).
 *          - `jd`: The Jalali day of the month.
 */
export function toJalali(year: number, month: number, day: number): JalaliDate {
    const g_days_in_month = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
    const j_days_in_month = [31, 31, 31, 30, 31, 30, 31, 31, 30, 31, 30, 29];
    const g_days_in_year = 365;
    const j_days_in_year = 366;

    let jy = year - 621;

    // تعداد روزهای میلادی از ابتدای سال
    let g_day_no = day;
    for (let i = 0; i < month - 1; i++) {
        g_day_no += g_days_in_month[i];
    }

    // در نظر گرفتن سال کبیسه
    if (month > 2 && ((year % 4 === 0 && year % 100 !== 0) || (year % 400 === 0))) {
        g_day_no++;
    }

    // تعداد روزهای میلادی از تاریخ صفر
    g_day_no += 365 * (year - 1) + Math.floor((year - 1) / 4) - Math.floor((year - 1) / 100) + Math.floor((year - 1) / 400);

    // تعداد روزهای شمسی از تاریخ صفر
    let j_day_no = g_day_no - 79;

    // محاسبه سال شمسی
    jy += 33 * Math.floor(j_day_no / 12053);
    j_day_no %= 12053;
    jy += 4 * Math.floor(j_day_no / 1461);
    j_day_no %= 1461;

    if (j_day_no >= 366) {
        jy += Math.floor((j_day_no - 1) / 365);
        j_day_no = (j_day_no - 1) % 365;
    }

    // محاسبه ماه و روز شمسی
    let jm = 0;
    let jd = 0;
    for (let i = 0; i < 12; i++) {
        if (j_day_no < j_days_in_month[i]) {
            jm = i + 1;
            jd = j_day_no + 1;
            break;
        }
        j_day_no -= j_days_in_month[i];
    }

    return { jy, jm, jd };
}

/**
 * Gets the day of the week for a given date.
 *
 * @param date - The date to evaluate, provided as a string or a Date object.
 * @returns The day of the week as a number (0 for Sunday, 1 for Monday, ..., 6 for Saturday).
 */
export function getDayOfWeek(date: string | Date): number {
    const dayDate = new Date(date);
    return dayDate.getDay();
}
