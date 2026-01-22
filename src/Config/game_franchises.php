<?php

declare(strict_types=1);

/*
 * This file is part of a Symfony Application built by Enabel.
 * Copyright (c) Enabel <https://github.com/Enabel>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [
    // Call of Duty - specific subtitles first (more specific patterns)
    'Black Ops' => ['franchise' => 'Call of Duty Black Ops', 'pattern' => '/(?:Call\s+of\s+Duty\s*:?\s*)?Black\s+Ops(?:\s+[IVX\d]+)?/iu'],
    'Warzone' => ['franchise' => 'Call of Duty Warzone', 'pattern' => '/(?:Call\s+of\s+Duty\s*:?\s*)?Warzone(?:\s+[IVX\d]+)?/iu'],
    'Modern Warfare' => ['franchise' => 'Call of Duty Modern Warfare', 'pattern' => '/(?:Call\s+of\s+Duty\s*:?\s*)?Modern\s+Warfare(?:\s+[IVX\d]+)?/iu'],
    'Call of Duty' => ['franchise' => 'Call of Duty', 'pattern' => '/Call\s+of\s+Duty(?:\s*:?\s*[A-Z][a-z]+(?:\s+[A-Z]?[a-z]+){0,3}(?:\s+[IVX\d]+)?)?/u'],
    'CoD' => ['franchise' => 'Call of Duty', 'pattern' => '/\bCoD\b/iu'],

    // Grand Theft Auto
    'GTA' => ['franchise' => 'GTA', 'pattern' => '/GTA\s*(?:VI|V|IV|6|5|4|Online)?/iu'],
    'Grand Theft' => ['franchise' => 'Grand Theft Auto', 'pattern' => '/Grand\s+Theft\s+Auto(?:\s*(?:VI|V|IV|6|5|4))?/iu'],

    // The Legend of Zelda - specific titles first
    'Tears of the Kingdom' => ['franchise' => 'Zelda Tears of the Kingdom', 'pattern' => '/(?:The\s+Legend\s+of\s+)?(?:Zelda\s*:?\s*)?Tears\s+of\s+the\s+Kingdom/iu'],
    'Breath of the Wild' => ['franchise' => 'Zelda Breath of the Wild', 'pattern' => '/(?:The\s+Legend\s+of\s+)?(?:Zelda\s*:?\s*)?Breath\s+of\s+the\s+Wild/iu'],
    'Echoes of Wisdom' => ['franchise' => 'Zelda Echoes of Wisdom', 'pattern' => '/(?:The\s+Legend\s+of\s+)?(?:Zelda\s*:?\s*)?Echoes\s+of\s+Wisdom/iu'],
    'Zelda' => ['franchise' => 'Zelda', 'pattern' => '/(?:The\s+Legend\s+of\s+)?Zelda/iu'],

    // Final Fantasy
    'Final Fantasy' => ['franchise' => 'Final Fantasy', 'pattern' => '/Final\s+Fantasy(?:\s*(?:VII|XVI|XV|XIV|[IVXLCDM]+|\d+))?(?:\s+Rebirth|\s+Remake|\s+Online)?/iu'],

    // Assassin's Creed - specific titles first
    'Assassin' => ['franchise' => "Assassin's Creed", 'pattern' => "/Assassin'?s?\s+Creed(?:\s*:?\s*[A-Z][a-z]+(?:\s+[A-Z][a-z]+)?)?/u"],

    // Monster Hunter - specific titles
    'Monster Hunter Wilds' => ['franchise' => 'Monster Hunter Wilds', 'pattern' => '/Monster\s+Hunter\s+Wilds/iu'],
    'Monster Hunter World' => ['franchise' => 'Monster Hunter World', 'pattern' => '/Monster\s+Hunter\s+World(?:\s*:?\s*Iceborne)?/iu'],
    'Monster Hunter Rise' => ['franchise' => 'Monster Hunter Rise', 'pattern' => '/Monster\s+Hunter\s+Rise(?:\s*:?\s*Sunbreak)?/iu'],
    'Monster Hunter' => ['franchise' => 'Monster Hunter', 'pattern' => '/Monster\s+Hunter(?:\s+[A-Z][a-z]+)?/u'],

    // Resident Evil
    'Resident' => ['franchise' => 'Resident Evil', 'pattern' => '/Resident\s+Evil(?:\s*(?:\d+|Village|Biohazard))?/iu'],
    'Biohazard' => ['franchise' => 'Resident Evil', 'pattern' => '/Biohazard(?:\s*\d+)?/iu'],

    // Pokémon
    'Pokémon' => ['franchise' => 'Pokémon', 'pattern' => '/Pok[ée]mon(?:\s+[\w\s]+)?/iu'],
    'Pokemon' => ['franchise' => 'Pokémon', 'pattern' => '/Pokemon(?:\s+[\w\s]+)?/iu'],

    // Elden Ring / FromSoftware
    'Elden Ring' => ['franchise' => 'Elden Ring', 'pattern' => '/Elden\s+Ring(?:\s*:?\s*[\w\s]+)?/iu'],
    'Dark Souls' => ['franchise' => 'Dark Souls', 'pattern' => '/Dark\s+Souls(?:\s*(?:I{1,3}|\d+))?/iu'],
    'Bloodborne' => ['franchise' => 'Bloodborne', 'pattern' => '/Bloodborne/iu'],
    'Sekiro' => ['franchise' => 'Sekiro', 'pattern' => '/Sekiro(?:\s*:?\s*[\w\s]+)?/iu'],

    // The Witcher
    'Witcher' => ['franchise' => 'The Witcher', 'pattern' => '/(?:The\s+)?Witcher(?:\s*(?:\d+|IV))?/iu'],
    'Geralt' => ['franchise' => 'The Witcher', 'pattern' => '/Geralt/iu'],

    // Cyberpunk
    'Cyberpunk' => ['franchise' => 'Cyberpunk 2077', 'pattern' => '/Cyberpunk(?:\s+2077)?/iu'],

    // Red Dead
    'Red Dead' => ['franchise' => 'Red Dead Redemption', 'pattern' => '/Red\s+Dead(?:\s+Redemption)?(?:\s*\d+)?/iu'],

    // God of War
    'God of War Ragnarok' => ['franchise' => 'God of War Ragnarok', 'pattern' => '/God\s+of\s+War\s+Ragnar[oö]k/iu'],
    'God of War' => ['franchise' => 'God of War', 'pattern' => '/God\s+of\s+War(?:\s+[A-Z][a-z]+)?/u'],
    'Kratos' => ['franchise' => 'God of War', 'pattern' => '/Kratos/iu'],

    // Horizon
    'Horizon' => ['franchise' => 'Horizon', 'pattern' => '/Horizon(?:\s+(?:Zero\s+Dawn|Forbidden\s+West))?/iu'],

    // Spider-Man
    'Spider-Man' => ['franchise' => 'Spider-Man', 'pattern' => '/Spider-?Man(?:\s*(?:2|\d+|Miles\s+Morales))?/iu'],

    // Starfield / Bethesda
    'Starfield' => ['franchise' => 'Starfield', 'pattern' => '/Starfield/iu'],
    'Elder Scrolls' => ['franchise' => 'The Elder Scrolls', 'pattern' => '/(?:The\s+)?Elder\s+Scrolls(?:\s*(?:VI|V|IV|\d+|Online))?/iu'],
    'Skyrim' => ['franchise' => 'Skyrim', 'pattern' => '/Skyrim/iu'],
    'Fallout' => ['franchise' => 'Fallout', 'pattern' => '/Fallout(?:\s*(?:\d+|76))?/iu'],

    // Diablo
    'Diablo' => ['franchise' => 'Diablo', 'pattern' => '/Diablo(?:\s*(?:IV|4|\d+))?/iu'],

    // World of Warcraft
    'World of Warcraft' => ['franchise' => 'World of Warcraft', 'pattern' => '/World\s+of\s+Warcraft(?:\s*:?\s*[\w\s]+)?/iu'],
    'WoW' => ['franchise' => 'World of Warcraft', 'pattern' => '/WoW(?:\s*:?\s*[\w\s]+)?/iu'],

    // League of Legends
    'League of Legends' => ['franchise' => 'League of Legends', 'pattern' => '/League\s+of\s+Legends/iu'],
    'LoL' => ['franchise' => 'League of Legends', 'pattern' => '/\bLoL\b/iu'],

    // Fortnite
    'Fortnite' => ['franchise' => 'Fortnite', 'pattern' => '/Fortnite/iu'],

    // Minecraft
    'Minecraft' => ['franchise' => 'Minecraft', 'pattern' => '/Minecraft/iu'],

    // Mario
    'Mario' => ['franchise' => 'Mario', 'pattern' => '/(?:Super\s+)?Mario(?:\s+(?:Kart|Party|Bros|Odyssey|Wonder))?(?:\s*\d+)?/iu'],
    'Mario Kart' => ['franchise' => 'Mario Kart', 'pattern' => '/Mario\s+Kart(?:\s*\d+)?/iu'],

    // Metroid
    'Metroid' => ['franchise' => 'Metroid', 'pattern' => '/Metroid(?:\s+(?:Prime|Dread))?(?:\s*\d+)?/iu'],
    'Samus' => ['franchise' => 'Metroid', 'pattern' => '/Samus/iu'],

    // Halo
    'Halo' => ['franchise' => 'Halo', 'pattern' => '/Halo(?:\s+(?:Infinite|\d+))?/iu'],

    // FIFA / EA Sports FC
    'FIFA' => ['franchise' => 'FIFA', 'pattern' => '/FIFA(?:\s*\d+)?/iu'],
    'EA Sports FC' => ['franchise' => 'EA Sports FC', 'pattern' => '/EA\s+Sports\s+FC(?:\s*\d+)?/iu'],

    // Battlefield
    'Battlefield' => ['franchise' => 'Battlefield', 'pattern' => '/Battlefield(?:\s*(?:\d+|V|2042))?/iu'],

    // Mass Effect
    'Mass Effect' => ['franchise' => 'Mass Effect', 'pattern' => '/Mass\s+Effect(?:\s*(?:\d+|Andromeda))?/iu'],

    // Dragon Age
    'Dragon Age' => ['franchise' => 'Dragon Age', 'pattern' => '/Dragon\s+Age(?:\s*:?\s*[\w\s]+)?/iu'],

    // Baldur's Gate
    'Baldur' => ['franchise' => "Baldur's Gate", 'pattern' => "/Baldur'?s?\s+Gate(?:\s*(?:\d+|III))?/iu"],

    // Doom
    'Doom' => ['franchise' => 'Doom', 'pattern' => '/Doom(?:\s+(?:Eternal|\d+))?/iu'],

    // Metal Gear
    'Metal Gear' => ['franchise' => 'Metal Gear', 'pattern' => '/Metal\s+Gear(?:\s+Solid)?(?:\s*(?:V|\d+))?/iu'],

    // Death Stranding
    'Death Stranding' => ['franchise' => 'Death Stranding', 'pattern' => '/Death\s+Stranding(?:\s*\d+)?/iu'],

    // Silent Hill
    'Silent Hill' => ['franchise' => 'Silent Hill', 'pattern' => '/Silent\s+Hill(?:\s*\d+)?/iu'],

    // Tekken
    'Tekken' => ['franchise' => 'Tekken', 'pattern' => '/Tekken(?:\s*\d+)?/iu'],

    // Street Fighter
    'Street Fighter' => ['franchise' => 'Street Fighter', 'pattern' => '/Street\s+Fighter(?:\s*(?:\d+|VI|V))?/iu'],

    // Mortal Kombat
    'Mortal Kombat' => ['franchise' => 'Mortal Kombat', 'pattern' => '/Mortal\s+Kombat(?:\s*(?:\d+|1))?/iu'],

    // Splatoon
    'Splatoon' => ['franchise' => 'Splatoon', 'pattern' => '/Splatoon(?:\s*\d+)?/iu'],

    // Animal Crossing
    'Animal Crossing' => ['franchise' => 'Animal Crossing', 'pattern' => '/Animal\s+Crossing(?:\s*:?\s*[\w\s]+)?/iu'],

    // Smash Bros
    'Smash Bros' => ['franchise' => 'Super Smash Bros', 'pattern' => '/(?:Super\s+)?Smash\s+Bros(?:\.)?(?:\s+[\w\s]+)?/iu'],

    // Persona
    'Persona' => ['franchise' => 'Persona', 'pattern' => '/Persona(?:\s*\d+)?(?:\s+[\w\s]+)?/iu'],

    // Kingdom Hearts
    'Kingdom Hearts' => ['franchise' => 'Kingdom Hearts', 'pattern' => '/Kingdom\s+Hearts(?:\s*(?:\d+|III|IV))?/iu'],

    // Prince of Persia
    'Prince of Persia' => ['franchise' => 'Prince of Persia', 'pattern' => '/Prince\s+of\s+Persia(?:\s*:?\s*(?:Les\s+Sables\s+du\s+Temps|The\s+Sands\s+of\s+Time|The\s+Lost\s+Crown|Warrior\s+Within|The\s+Two\s+Thrones))?/iu'],
    'Sables du Temps' => ['franchise' => 'Prince of Persia Les Sables du Temps', 'pattern' => '/(?:Prince\s+of\s+Persia\s*:?\s*)?Les\s+Sables\s+du\s+Temps/iu'],
    'Lost Crown' => ['franchise' => 'Prince of Persia The Lost Crown', 'pattern' => '/(?:Prince\s+of\s+Persia\s*:?\s*)?The\s+Lost\s+Crown/iu'],

    // Tomb Raider
    'Tomb Raider' => ['franchise' => 'Tomb Raider', 'pattern' => '/Tomb\s+Raider/iu'],
    'Lara Croft' => ['franchise' => 'Tomb Raider', 'pattern' => '/Lara\s+Croft/iu'],

    // Uncharted
    'Uncharted' => ['franchise' => 'Uncharted', 'pattern' => '/Uncharted(?:\s*(?:\d+))?/iu'],

    // The Last of Us
    'Last of Us' => ['franchise' => 'The Last of Us', 'pattern' => '/(?:The\s+)?Last\s+of\s+Us(?:\s+(?:Part\s+)?(?:I{1,2}|\d+))?/iu'],

    // Ghost of Tsushima
    'Ghost of Tsushima' => ['franchise' => 'Ghost of Tsushima', 'pattern' => '/Ghost\s+of\s+Tsushima/iu'],

    // Alan Wake
    'Alan Wake' => ['franchise' => 'Alan Wake', 'pattern' => '/Alan\s+Wake(?:\s*\d+)?/iu'],

    // Control
    'Control' => ['franchise' => 'Control', 'pattern' => '/\bControl\b/iu'],

    // Hogwarts Legacy
    'Hogwarts' => ['franchise' => 'Hogwarts Legacy', 'pattern' => '/Hogwarts(?:\s+Legacy)?/iu'],

    // Palworld
    'Palworld' => ['franchise' => 'Palworld', 'pattern' => '/Palworld/iu'],

    // Helldivers
    'Helldivers' => ['franchise' => 'Helldivers', 'pattern' => '/Helldivers(?:\s*\d+)?/iu'],

    // Stellar Blade
    'Stellar Blade' => ['franchise' => 'Stellar Blade', 'pattern' => '/Stellar\s+Blade/iu'],

    // Life is Strange
    'Life is Strange' => ['franchise' => 'Life is Strange', 'pattern' => '/Life\s+is\s+Strange(?:\s*(?:\d+|2|True\s+Colors|Double\s+Exposure))?/iu'],

    // Like a Dragon / Yakuza
    'Like a Dragon' => ['franchise' => 'Like a Dragon', 'pattern' => '/Like\s+a\s+Dragon(?:\s*:?\s*[\w\s]+)?/iu'],
    'Yakuza' => ['franchise' => 'Yakuza', 'pattern' => '/Yakuza(?:\s*(?:\d+|Kiwami))?/iu'],
];
