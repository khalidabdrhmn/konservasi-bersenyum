import test from 'node:test';
import assert from 'node:assert/strict';
import { formatAdminDate } from '../../public/js/admin-date.js';

test('formats Laravel ISO date timestamps', () => {
    assert.equal(
        formatAdminDate('2026-09-28T00:00:00.000000Z'),
        new Intl.DateTimeFormat('id-ID', { dateStyle: 'medium' }).format(new Date(2026, 8, 28)),
    );
});

test('formats date-only values without adding a duplicate time suffix', () => {
    assert.equal(
        formatAdminDate('2026-09-28'),
        new Intl.DateTimeFormat('id-ID', { dateStyle: 'medium' }).format(new Date(2026, 8, 28)),
    );
});

test('returns a placeholder for missing or invalid dates', () => {
    assert.equal(formatAdminDate(null), '-');
    assert.equal(formatAdminDate('not-a-date'), '-');
    assert.equal(formatAdminDate('2026-02-31'), '-');
});
