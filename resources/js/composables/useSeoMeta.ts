import { onBeforeUnmount, watchEffect, type MaybeRefOrGetter, toValue } from 'vue';

type SeoMetaInput = {
    title?: MaybeRefOrGetter<string>;
    description?: MaybeRefOrGetter<string>;
};

function ensureMetaTag(name: string): HTMLMetaElement | null {
    if (typeof document === 'undefined') {
        return null;
    }

    let element = document.head.querySelector(`meta[name=\"${name}\"]`) as HTMLMetaElement | null;

    if (!element) {
        element = document.createElement('meta');
        element.setAttribute('name', name);
        document.head.appendChild(element);
    }

    return element;
}

export function useSeoMeta(meta: SeoMetaInput): void {
    if (typeof document === 'undefined') {
        return;
    }

    const initialTitle = document.title;
    const descriptionElement = ensureMetaTag('description');
    const initialDescription = descriptionElement?.getAttribute('content') ?? '';

    watchEffect(() => {
        const nextTitle = meta.title ? toValue(meta.title) : '';
        const nextDescription = meta.description ? toValue(meta.description) : '';

        if (nextTitle) {
            document.title = nextTitle;
        }

        if (descriptionElement && nextDescription) {
            descriptionElement.setAttribute('content', nextDescription);
        }
    });

    onBeforeUnmount(() => {
        document.title = initialTitle;
        if (descriptionElement) {
            descriptionElement.setAttribute('content', initialDescription);
        }
    });
}
