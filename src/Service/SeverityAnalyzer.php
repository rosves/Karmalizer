<?php
namespace App\Service;

class SeverityAnalyzer
{
    private array $badWords = [
        'merde', 'putain', 'enculé', 'salope', 'connard', 'con', 'batard', 'fdp', 'ta gueule',
        'nique', 'pédé', 'chiant', 'débile', 'abruti', 'salaud', 'clochard', 'pute', 'trouduc',
        'bouffon', 'baltringue', 'enfoiré', 'fils de pute', 'gros con', 'sale con', 'sale pute',
        'ferme ta gueule', 'gouine', 'tapette', 'branleur', 'branleuse', 'sac à merde',
        'casse-couilles', 'connasse', 'trou du cul', 'emmerdeur', 'emmerdeuse', 'bite',
        'couille', 'chatte', 'cul', 'bordel', 'nique ta mère', 'enculé de ta race',
        'raclure', 'sale race', 'pisseuse', 'chiotte', 'porc', 'crevard',
        'idiot', 'stupide', 'incompétent', 'mauvais', 'nul', 'minable', 'faible', 'médiocre',
        'horrible', 'détestable', 'méchant', 'ridicule', 'lamentable', 'désespérant', 'fainéant',
        'immonde', 'laid', 'moche', 'insupportable', 'pénible', 'injuste', 'faux', 'mensonger',
        'triste', 'désastreux', 'toxique', 'foutu', 'haineux', 'arrogant', 'violent', 'méprisable',
        'froid', 'hypocrite', 'jaloux', 'colérique', 'agressif', 'hostile', 'malveillant',
        'perfide', 'abusif', 'tyrannique', 'déloyal', 'égoïste', 'paresseux', 'odieux',
        'solitaire', 'désagréable', 'impossible', 'angoissant', 'terrifiant',
    ];

    public function analyze(string $text): int
    {
        $text = mb_strtolower($text);
        $count = 0;

        foreach ($this->badWords as $word) {
            $pattern = '/\b' . preg_quote($word, '/') . '\b/u';
            if (preg_match_all($pattern, $text, $matches)) {
                $count += count($matches[0]);
            }
        }

        if ($count === 0) {
            return 0;
        } elseif ($count < 2) {
            return 1;
        } elseif ($count < 4) {
            return 2;
        } else {
            return 3;
        }
    }
}
