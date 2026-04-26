export type CookiePreferences = {
    necessary: boolean;
    analytics: boolean;
    marketing: boolean;
};

const STORAGE_KEY = 'studio-kristian-cookie-preferences';

const DEFAULT_PREFERENCES: CookiePreferences = {
    necessary: true,
    analytics: false,
    marketing: false,
};

function isBrowser(): boolean {
    return typeof window !== 'undefined' && typeof window.localStorage !== 'undefined';
}

export function getCookiePreferences(): CookiePreferences | null {
    if (!isBrowser()) {
        return null;
    }

    const raw = window.localStorage.getItem(STORAGE_KEY);
    if (!raw) {
        return null;
    }

    try {
        const parsed = JSON.parse(raw) as Partial<CookiePreferences>;
        return {
            necessary: true,
            analytics: Boolean(parsed.analytics),
            marketing: Boolean(parsed.marketing),
        };
    } catch {
        return null;
    }
}

export function setCookiePreferences(preferences: CookiePreferences): void {
    if (!isBrowser()) {
        return;
    }

    const safePreferences: CookiePreferences = {
        necessary: true,
        analytics: Boolean(preferences.analytics),
        marketing: Boolean(preferences.marketing),
    };

    window.localStorage.setItem(STORAGE_KEY, JSON.stringify(safePreferences));
}

export function hasCookieConsentBeenSet(): boolean {
    return getCookiePreferences() !== null;
}

export function getEffectiveCookiePreferences(): CookiePreferences {
    return getCookiePreferences() ?? DEFAULT_PREFERENCES;
}
