<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

enum GenreEnum: string
{
    case sf_history = 'sf_history';
    case sf_action = 'sf_action';
    case sf_epic = 'sf_epic';
    case sf_heroic = 'sf_heroic';
    case sf_detective = 'sf_detective';
    case sf_cyberpunk = 'sf_cyberpunk';
    case sf_space = 'sf_space';
    case sf_social = 'sf_social';
    case sf_horror = 'sf_horror';
    case sf_humor = 'sf_humor';
    case sf_fantasy = 'sf_fantasy';
    case sf = 'sf';

    case det_classic = 'det_classic';
    case det_police = 'det_police';
    case det_action = 'det_action';
    case det_irony = 'det_irony';
    case det_history = 'det_history';
    case det_espionage = 'det_espionage';
    case det_crime = 'det_crime';
    case det_political = 'det_political';
    case det_maniac = 'det_maniac';
    case det_hard = 'det_hard';
    case thriller = 'thriller';
    case detective = 'detective';

    case prose_classic = 'prose_classic';
    case prose_history = 'prose_history';
    case prose_contemporary = 'prose_contemporary';
    case prose_counter = 'prose_counter';
    case prose_rus_classic = 'prose_rus_classic';
    case prose_su_classics = 'prose_su_classics';

    case love_contemporary = 'love_contemporary';
    case love_history = 'love_history';
    case love_detective = 'love_detective';
    case love_short = 'love_short';
    case love_erotica = 'love_erotica';

    case adv_western = 'adv_western';
    case adv_history = 'adv_history';
    case adv_indian = 'adv_indian';
    case adv_maritime = 'adv_maritime';
    case adv_geo = 'adv_geo';
    case adv_animal = 'adv_animal';
    case adventure = 'adventure';

    case child_tale = 'child_tale';
    case child_verse = 'child_verse';
    case child_prose = 'child_prose';
    case child_sf = 'child_sf';
    case child_det = 'child_det';
    case child_adv = 'child_adv';
    case child_education = 'child_education';
    case children = 'children';

    case poetry = 'poetry';
    case dramaturgy = 'dramaturgy';

    case antique_ant = 'antique_ant';
    case antique_european = 'antique_european';
    case antique_russian = 'antique_russian';
    case antique_east = 'antique_east';
    case antique_myths = 'antique_myths';
    case antique = 'antique';

    case sci_history = 'sci_history';
    case sci_psychology = 'sci_psychology';
    case sci_culture = 'sci_culture';
    case sci_religion = 'sci_religion';
    case sci_philosophy = 'sci_philosophy';
    case sci_politics = 'sci_politics';
    case sci_business = 'sci_business';
    case sci_juris = 'sci_juris';
    case sci_linguistic = 'sci_linguistic';
    case sci_medicine = 'sci_medicine';
    case sci_phys = 'sci_phys';
    case sci_math = 'sci_math';
    case sci_chem = 'sci_chem';
    case sci_biology = 'sci_biology';
    case sci_tech = 'sci_tech';
    case science = 'science';

    case comp_www = 'comp_www';
    case comp_programming = 'comp_programming';
    case comp_hard = 'comp_hard';
    case comp_soft = 'comp_soft';
    case comp_db = 'comp_db';
    case comp_osnet = 'comp_osnet';
    case computers = 'computers';

    case ref_encyc = 'ref_encyc';
    case ref_dict = 'ref_dict';
    case ref_ref = 'ref_ref';
    case ref_guide = 'ref_guide';
    case reference = 'reference';

    case nonf_biography = 'nonf_biography';
    case nonf_publicism = 'nonf_publicism';
    case nonf_criticism = 'nonf_criticism';
    case design = 'design';
    case nonfiction = 'nonfiction';

    case religion_rel = 'religion_rel';
    case religion_esoterics = 'religion_esoterics';
    case religion_self = 'religion_self';
    case religion = 'Other';

    case humor_anecdote = 'humor_anecdote';
    case humor_prose = 'humor_prose';
    case humor_verse = 'humor_verse';
    case humor = 'humor';

    case home_cooking = 'home_cooking';
    case home_pets = 'home_pets';
    case home_crafts = 'home_crafts';
    case home_entertain = 'home_entertain';
    case home_health = 'home_health';
    case home_garden = 'home_garden';
    case home_diy = 'home_diy';
    case home_sport = 'home_sport';
    case home_sex = 'home_sex';
    case home = 'home';

    public function description(): string
    {
        return match ($this) {
            self::sf_history => 'Alternative history',
            self::sf_action => 'Action',
            self::sf_epic => 'Epic',
            self::sf_heroic => 'Heroic',
            self::sf_detective => 'Detective',
            self::sf_cyberpunk => 'Cyberpunk',
            self::sf_space => 'Space',
            self::sf_social => 'Social-philosophical',
            self::sf_horror => 'Horror & mystic',
            self::sf_humor => 'Humor',
            self::sf_fantasy => 'Fantasy',
            self::sf => 'Science Fiction',


            self::det_classic => 'Classical detectives',
            self::det_police => 'Police Stories',
            self::det_action => 'Action',
            self::det_irony => 'Ironical detectives',
            self::det_history => 'Historical detectives',
            self::det_espionage => 'Espionage detectives',
            self::det_crime => 'Crime detectives',
            self::det_political => 'Political detectives',
            self::det_maniac => 'Maniacs',
            self::det_hard => 'Hard-boiled',
            self::thriller => 'Thrillers',
            self::detective => 'Detectives',

            self::prose_classic => 'Classics prose',
            self::prose_history => 'Historical prose',
            self::prose_contemporary => 'Contemporary prose',
            self::prose_counter => 'Counterculture',
            self::prose_rus_classic => 'Russial classics prose',
            self::prose_su_classics => 'Soviet classics prose',

            self::love_contemporary => 'Contemporary Romance',
            self::love_history => 'Historical Romance',
            self::love_detective => 'Detective Romance',
            self::love_short => 'Short Romance',
            self::love_erotica => 'Erotica',

            self::adv_western => 'Western',
            self::adv_history => 'History',
            self::adv_indian => 'Indians',
            self::adv_maritime => 'Maritime Fiction',
            self::adv_geo => 'Travel & geography',
            self::adv_animal => 'Nature & animals',
            self::adventure => 'Other',

            self::child_tale => 'Fairy Tales',
            self::child_verse => 'Verses',
            self::child_prose => 'Prose',
            self::child_sf => 'Science Fiction',
            self::child_det => 'Detectives & Thrillers',
            self::child_adv => 'Adventures',
            self::child_education => 'Educational',
            self::children => 'Other',

            self::poetry => 'Poetry',
            self::dramaturgy => 'Dramaturgy',

            self::antique_ant => 'Antique',
            self::antique_european => 'European',
            self::antique_russian => 'Old russian',
            self::antique_east => 'Old east',
            self::antique_myths => 'Myths. Legends. Epos',
            self::antique => 'Other',

            self::sci_history => 'History',
            self::sci_psychology => 'Psychology',
            self::sci_culture => 'Cultural science',
            self::sci_religion => 'Religious studies',
            self::sci_philosophy => 'Philosophy',
            self::sci_politics => 'Politics',
            self::sci_business => 'Business literature',
            self::sci_juris => 'Jurisprudence',
            self::sci_linguistic => 'Linguistics',
            self::sci_medicine => 'Medicine',
            self::sci_phys => 'Physics',
            self::sci_math => 'Mathematics',
            self::sci_chem => 'Chemistry',
            self::sci_biology => 'Biology',
            self::sci_tech => 'Technical',
            self::science => 'Other',

            self::comp_www => 'Internet',
            self::comp_programming => 'Programming',
            self::comp_hard => 'Hardware',
            self::comp_soft => 'Software',
            self::comp_db => 'Databases',
            self::comp_osnet => 'OS & Networking',
            self::computers => 'Other',

            self::ref_encyc => 'Encyclopedias',
            self::ref_dict => 'Dictionaries',
            self::ref_ref => 'Reference',
            self::ref_guide => 'Guidebooks',
            self::reference => 'Other',

            self::nonf_biography => 'Biography & Memoirs',
            self::nonf_publicism => 'Publicism',
            self::nonf_criticism => 'Criticism',
            self::design => 'Art & design',
            self::nonfiction => 'Other',

            self::religion_rel => 'Religion',
            self::religion_esoterics => 'Esoterics',
            self::religion_self => 'Self-improvement',
            self::religion => 'Other',

            self::humor_anecdote => 'Anecdote (funny stories)',
            self::humor_prose => 'Prose',
            self::humor_verse => 'Verses',
            self::humor => 'Other',

            self::home_cooking => 'Cooking',
            self::home_pets => 'Pets',
            self::home_crafts => 'Hobbies & Crafts',
            self::home_entertain => 'Entertaining',
            self::home_health => 'Health',
            self::home_garden => 'Garden',
            self::home_diy => 'Do it yourself',
            self::home_sport => 'Sports',
            self::home_sex => 'Erotica & sex',
            self::home => 'Other',
        };
    }

    /**
     * @return string[]
     */
    public static function values(): array
    {
        return array_map(
            static fn(self $type) => $type->value,
            self::cases()
        );
    }
}
