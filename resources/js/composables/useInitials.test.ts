import assert from 'node:assert';
import { test } from 'node:test';
import { getInitials } from './useInitials.ts';

test('getInitials - returns initials for a full name', () => {
    assert.strictEqual(getInitials('John Doe'), 'JD');
});

test('getInitials - returns initials for a single name', () => {
    assert.strictEqual(getInitials('John'), 'J');
});

test('getInitials - returns initials for multiple names (first and last)', () => {
    assert.strictEqual(getInitials('John Quincy Adams'), 'JA');
});

test('getInitials - handles leading/trailing and extra whitespace', () => {
    assert.strictEqual(getInitials('  John   Doe  '), 'JD');
});

test('getInitials - returns empty string for undefined', () => {
    assert.strictEqual(getInitials(undefined), '');
});

test('getInitials - returns empty string for empty input', () => {
    assert.strictEqual(getInitials(''), '');
    assert.strictEqual(getInitials('   '), '');
});

test('getInitials - returns uppercase initials regardless of input case', () => {
    assert.strictEqual(getInitials('john doe'), 'JD');
    assert.strictEqual(getInitials('JOHN DOE'), 'JD');
});
