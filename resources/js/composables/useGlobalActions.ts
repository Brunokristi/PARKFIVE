const CONTACT_PHONE_E164 = '421911454678';
const CONTACT_EMAIL = 'hello@studiokristian.com';

const INSTAGRAM_URL = 'https://www.instagram.com/studiokristian/';
const MESSENGER_URL = 'https://m.me/studiokristian';

function navigate(path: string): void {
    if (typeof window === 'undefined') {
        return;
    }

    window.location.href = path;
}

function openExternal(url: string): void {
    if (typeof window === 'undefined') {
        return;
    }

    window.open(url, '_blank', 'noopener,noreferrer');
}

export function useGlobalActions() {
    const openContacts = () => navigate('/contact');
    const openRecentProjects = () => navigate('/portfolio');
    const openWorkflow = () => navigate('/workflow');
    const openPrivacyPolicy = () => navigate('/privacy-policy');

    const openInstagram = () => openExternal(INSTAGRAM_URL);
    const openMessenger = () => openExternal(MESSENGER_URL);

    const openEmail = () => {
        navigate(`mailto:${CONTACT_EMAIL}`);
    };

    const openMessage = () => {
        navigate(`sms:+${CONTACT_PHONE_E164}`);
    };

    const openWhatsApp = () => {
        openExternal(`https://wa.me/${CONTACT_PHONE_E164}`);
    };

    const openVcard = () => {
        navigate('/vcard.vcf');
    };

    return {
        openContacts,
        openRecentProjects,
        openWorkflow,
        openPrivacyPolicy,
        openInstagram,
        openMessenger,
        openEmail,
        openMessage,
        openWhatsApp,
        openVcard,
    };
}
