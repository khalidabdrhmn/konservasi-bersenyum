export function formatAdminDate(value) {
    if (!value) return '-';

    const datePart = typeof value === 'string'
        ? value.match(/^(\d{4})-(\d{2})-(\d{2})(?:$|T)/)
        : null;
    let parsed;

    if (datePart) {
        const [, year, month, day] = datePart;
        parsed = new Date(Number(year), Number(month) - 1, Number(day));

        if (
            parsed.getFullYear() !== Number(year)
            || parsed.getMonth() !== Number(month) - 1
            || parsed.getDate() !== Number(day)
        ) {
            return '-';
        }
    } else {
        parsed = new Date(value);
    }

    if (Number.isNaN(parsed.getTime())) return '-';

    return new Intl.DateTimeFormat('id-ID', { dateStyle: 'medium' }).format(parsed);
}
