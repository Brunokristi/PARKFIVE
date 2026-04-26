import { getEffectiveCookiePreferences } from './useCookieConsent';

declare global {
    interface Window {
        dataLayer?: unknown[];
        gtag?: (...args: unknown[]) => void;
        __GA_MEASUREMENT_ID?: string;
    }
}

function isBrowser(): boolean {
    return typeof window !== 'undefined';
}

function getMeasurementId(): string {
    if (!isBrowser()) {
        return '';
    }

    return window.__GA_MEASUREMENT_ID ?? '';
}

function canUseAnalytics(): boolean {
    if (!isBrowser()) {
        return false;
    }

    const preferences = getEffectiveCookiePreferences();
    return preferences.analytics === true;
}

function safeGtag(...args: unknown[]): void {
    if (!isBrowser() || typeof window.gtag !== 'function') {
        return;
    }

    window.gtag(...args);
}

export function enableAnalytics(): void {
    safeGtag('consent', 'update', {
        ad_storage: 'denied',
        analytics_storage: 'granted',
        functionality_storage: 'granted',
        personalization_storage: 'denied',
        security_storage: 'granted',
    });
}

export function disableAnalytics(): void {
    safeGtag('consent', 'update', {
        ad_storage: 'denied',
        analytics_storage: 'denied',
        functionality_storage: 'granted',
        personalization_storage: 'denied',
        security_storage: 'granted',
    });
}

export function initializeAnalyticsIfConsented(): void {
    if (!isBrowser()) {
        return;
    }

    if (canUseAnalytics()) {
        enableAnalytics();
    } else {
        disableAnalytics();
    }
}

export function trackPageViewIfConsented(path?: string): void {
    if (!isBrowser() || !canUseAnalytics()) {
        return;
    }

    const measurementId = getMeasurementId();
    if (!measurementId) {
        return;
    }

    const pagePath = path || window.location.pathname;

    safeGtag('event', 'page_view', {
        page_path: pagePath,
        page_location: window.location.href,
    });
}
