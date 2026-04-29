import { viewDepthKey } from "vue-router";

export default {
    home: {
        roomTypes: 'izby',
        menu: 'viac',
    },

    property: {
        subtitle: 'Hotel',
        description: 'Objavte naše izby, vybavenie a služby, ktoré sú dostupné počas vášho pobytu.',
        compareHeading: 'Porovnanie',
        compareDescription: 'Vyberte 2 typy izieb, ktoré chcete porovnať.',
        images: {
            alt1: 'Hotel',
            alt2: 'Izba',
        },
        sections: {
            amenities: {
                heading: 'vybavenie',
                rows: {
                    wifi: 'Wi-Fi',
                    parking: 'Parkovanie',
                    breakfast: 'Raňajky',
                },
            },
            services: {
                heading: 'služby',
                rows: {
                    reception: 'Recepcia',
                    cleaning: 'Upratovanie',
                    pets: 'Domáce zvieratá',
                },
            },
        },
        roomFeatures: {
            wifi: 'Wi-Fi',
            tv: 'TV',
            bathroom: 'Kúpeľňa',
            balcony: 'Balkón',
            view: 'Výhľad',
        },
        roomTypes: {
            standard: 'Štandard',
            premium: 'Premium',
            deluxe: 'Deluxe',
        },
    },
    nav: {
        home: 'Úvod',
        hotel: 'Ubytovanie',
        services: 'Služby',
        policies: 'Informácie',
        contact: 'Kontakt',
        planner: 'Plánovač',
        privacy: 'Súkromie',
        more: 'viac',
        language: 'jazyk',
        menu: 'menu',
    },
    navigation: {
        home: 'Domov',
        portfolio: 'Projekty',
        workflow: 'Proces',
        contact: 'Kontakt',
    },

    policies: {
        title: 'Pravidlá',
    },

    portfolio: {
        contact: 'Poďme vytvoriť váš projekt',
        loading: 'Načítavam projekty...',
        viewLive: 'Zobraziť naživo',
    },

    footer: {
        portfolio: 'Projekty',
        contact: 'Kontakt',
        workflow: 'Proces',
        privacy: 'Ochrana súkromia',
        email: 'Email',
        copyright: 'studio kristian. Všetky práva vyhradené.',
        facebook: 'Facebook',
        instagram: 'Instagram',
        home: 'Domov',
        cookies: 'Cookies'
    },

    contact: {
        email: 'Email',
        whatsapp: 'WhatsApp',
        message: 'Poslať správu',
        instagram: 'Instagram',
        messenger: 'Messenger',
    },

    contactPage: {
        title: 'SK headquarters',
        callEnded: 'Hovor ukončený ({time})',
        dragToCall: 'Kontaktuj potiahnutím',

        transcript: `Ahoj, vďaka za tvoj záujem. Väčšinou sa najskôr snažím pochopiť, čo skutočne potrebuješ. Niekedy je to jednoduchá webstránka s pevnou štruktúrou a čistým dizajnom. Niekedy je to väčší systém, ktorý šetrí čas, odstraňuje manuálnu prácu a zjednodušuje celý proces. Snažím sa udržať veci minimalistické, prehľadné a funkčné. Menej chaosu, menej klikov, lepšie výsledky. Ak to dáva zmysel, viem do procesu zapojiť aj automatizáciu alebo AI. Ak už máš nejakú predstavu, ozvi sa mi. A ak nie, to je v poriadku. Spolu na to prídeme.`,

        items: [
            {
                heading: 'Čo vlastne tvoríš?',
                text: 'Tvorím čisté webstránky a vlastné systémy navrhnuté na riešenie reálnych potrieb biznisu. Od jednoduchých prezentačných stránok až po komplexné nástroje, ktoré automatizujú procesy a šetria čas.',
            },
            {
                heading: 'S kým spolupracuješ?',
                text: 'Najčastejšie spolupracujem s malými firmami, zakladateľmi a nezávislými projektmi, ktoré chcú funkčné, prehľadné riešenie pripravené na rast.',
            },
            {
                heading: 'Ako dlho to trvá?',
                text: 'Záleží od rozsahu. Jednoduché weby môžu byť hotové už za týždeň, väčšie systémy trvajú dlhšie. Vždy sa snažím, aby bol proces efektívny a sústredený.',
            },
            {
                heading: 'Riešiš aj automatizáciu alebo AI?',
                text: 'Áno. Navrhujem systémy, ktoré znižujú manuálnu prácu a zjednodušujú procesy. Ak to dáva zmysel, integrujem automatizáciu alebo AI.',
            },
            {
                heading: 'Čo sa deje po spustení?',
                text: 'Projekt vieme ďalej rozvíjať a zlepšovať. Väčšina projektov sa časom vyvíja a ja ich navrhujem tak, aby rástli spolu s vaším biznisom.',
            },
            {
                heading: 'Koľko to stojí?',
                text: 'Každý projekt je iný, preto cena závisí od vašich potrieb. Sústreďujem sa na správne riešenie, nie na univerzálne balíky.',
            },
            {
                heading: 'Musím presne vedieť, čo chcem?',
                text: 'Nie nutne. Pomôžem vám preskúmať možnosti a nájsť najlepšie riešenie. Stačí sa podeliť o vašu predstavu a spoločne ju doladíme.',
            }
        ],
    },

    seo: {
        home: {
            title: 'studio kristian | Webstránky a systémy pre rast biznisu',
            description: 'studio kristian tvorí čisté weby, škálovateľné systémy a praktickú automatizáciu, ktoré pomáhajú firmám rásť rýchlejšie s menším množstvom manuálnej práce.',
        },
        portfolio: {
            title: 'Portfólio | projekty studio kristian',
            description: 'Pozrite si vybrané projekty studio kristian zamerané na výkon, prehľadnosť a reálny biznisový dopad.',
        },
        project: {
            title: 'Projekt | studio kristian',
            description: 'Objavte detaily projektov, rozhodnutia v procese a implementačné riešenia od studio kristian.',
        },
        workflow: {
            title: 'Proces | Od nápadu k systému | studio kristian',
            description: 'Pozrite sa, ako studio kristian mení nápady na funkčné digitálne systémy cez jasný a spolupracujúci proces.',
        },
        contact: {
            title: 'Kontakt | studio kristian',
            description: 'Kontaktujte studio kristian a preberieme webstránky, systémy, automatizáciu a praktické riešenia pre váš biznis.',
        },
    },

    privacy: {
        title: 'Ochrana súkromia',
        lastUpdated: 'Naposledy aktualizované: 29. marec 2026',
        sectionOverviewTitle: 'Prehľad',
        sectionOverviewText: 'Táto webstránka je prevádzkovaná studio kristian. Rešpektujeme tvoje súkromie a zhromažďujeme len minimálne údaje potrebné na fungovanie stránky.',
        sectionCookiesTitle: 'Cookies',
        sectionCookiesText: 'Táto stránka používa cookies. Niektoré sú nevyhnutné pre fungovanie, iné nám pomáhajú zlepšovať obsah a výkon stránky.',
        sectionAnalyticsTitle: 'Google Analytics',
        sectionAnalyticsText: 'Používame Google Analytics na meranie návštevnosti a správania používateľov. Dáta sú agregované a neslúžia na vašu identifikáciu.',
        sectionControlTitle: 'Vaše možnosti',
        sectionControlText: 'Cookies môžeš spravovať alebo vymazať v nastaveniach prehliadača. Môžeš tiež blokovať analytiku pomocou rozšírení.',
    },

    cookies: {
        title: 'Cookies a analytika',
        text: 'Stránka používa cookies a Google Analytics na zlepšovanie. Môžeš ich prijať alebo odmietnuť.',
        learnMore: 'Zobraziť zásady ochrany súkromia',
        reject: 'Odmietnuť',
        accept: 'Prijať všetko',
        policy: {
            title: "Nastavenia cookies",
            necessary: "Nevyhnutné cookies",
            necessaryDesc: "Potrebné pre fungovanie stránky.",
            necessaryList: "Session cookies, CSRF ochrana, preferencie",
            analytics: "Analytické cookies",
            analyticsDesc: "Pomáhajú zlepšiť používateľský zážitok.",
            analyticsList: "Google Analytics, zobrazenia stránok, správanie používateľov",
            marketing: "Marketingové cookies",
            marketingDesc: "Používajú sa na zobrazovanie relevantnej reklamy.",
            marketingList: "Konverzie, segmentácia publika, remarketing",
            always: "Vždy zapnuté",
            allowed: "Povolené",
            notAllowed: "Nepovolené",
            canChangeAnytime: "Nastavenia môžete kedykoľvek zmeniť.",
            rejectAll: "Odmietnuť všetko",
            acceptAll: "Prijať všetko",
            save: "Uložiť nastavenia",
            cancel: "Zrušiť"
        },
        toastAcceptedTitle: 'Cookies povolené',
        toastAcceptedText: 'Analytické a marketingové cookies boli povolené.',
        toastRejectedTitle: 'Cookies odmietnuté',
        toastRejectedText: 'Použijú sa iba nevyhnutné cookies.',
    },

    workflowPage: {
        steps: [
            {
                heading: '1. Úvodná analýza',
                text: 'Začínam pochopením tvojich cieľov, výziev a potrieb a spoločne hľadáme najvhodnejšie riešenia.',
            },
            {
                heading: '2. Definovanie rozsahu projektu',

                room: {
                    subtitle: 'Menej dizajnu. Vacsi efekt.',
                    heading: 'o mne',
                    description: 'Ciste weby a inteligentne systemy navrhnute pre rast vaseho biznisu.',
                    slideshow: {
                        project1Alt: 'Fotka projektu izby 1',
                        project2Alt: 'Fotka projektu izby 2',
                    },
                    table: {
                        section1: {
                            heading: 'Spalna 1',
                            row1: 'Filakovsky hrad',
                            row2: 'Filakovsky hrad',
                            row3: 'Filakovsky hrad',
                        },
                        section2: {
                            heading: 'Spalna 2',
                            row1: 'Filakovsky hrad',
                            row2: 'Filakovsky hrad',
                            row3: 'Filakovsky hrad',
                        },
                    },
                },

                slideshow: {
                    previousSlide: 'Predchadzajuci slide',
                    nextSlide: 'Dalsi slide',
                },
                text: 'Stanovím štruktúru, funkcie, časový plán a smerovanie projektu, aby bolo všetko jasné od začiatku.',
            },
            {
                heading: '3. Interaktívny prototyp',
                text: 'Môžeš sledovať návrh v reálnom čase, kontrolovať priebeh a dávať spätnú väzbu počas vývoja prototypu.',
            },
            {
                heading: '4. Vývoj',
                text: 'Schválený návrh prevediem do plne funkčnej a kvalitnej webstránky alebo aplikácie.',
            },
            {
                heading: '5. Spustenie',
                text: 'Projekt nasadím a uvediem do prevádzky s dôrazom na spoľahlivosť a bezproblémový chod.',
            },
            {
                heading: '6. Dokumentácia',
                text: 'Dostaneš prehľadnú dokumentáciu, ktorá vám pomôže projekt pochopiť a spravovať.',
            },
            {
                heading: '7. Odovzdanie a zaškolenie (ak je potrebné)',
                text: 'V prípade potreby zaškolím teba aj tvoj tím, aby ste vedeli s projektom pracovať samostatne.',
            },
            {
                heading: '8. Údržba a monitoring',
                text: 'Projekt môžeme ďalej sledovať a zlepšovať z pohľadu výkonu, použiteľnosti a stability.',
            },
            {
                heading: '9. Iteratívne zlepšovanie (voliteľné)',
                text: 'Na základe reálneho používania projekt postupne vylepšujeme.',
            },
        ],
        images: [
            {
                alt: 'Úvodné stretnutie k projektu',
                caption: 'Na začiatku si prejdeme detaily projektu a tvoje požiadavky',
            },
            {
                alt: 'Náhľad návrhu vo Figme',
                caption: 'Sleduj návrh v reálnom čase',
            },
            {
                alt: 'Implementácia projektu',
                caption: 'Vývoj webstránky alebo aplikácie',
            },
            {
                alt: 'Spustený projekt',
                caption: 'Projekt je spustený a dostupný online',
            },
            {
                alt: 'Analytika a monitoring',
                caption: 'Monitorovanie a podpora po spustení projektu',
            },
        ],
        callToAction: 'Projekty',
    },
}