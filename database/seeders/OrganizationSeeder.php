<?php

namespace Database\Seeders;

use App\Enums\OrganizationType;
use App\Models\County;
use App\Models\Organization;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizations = [
            ['Safe Haven Crisis Center', 'Providing 24/7 emergency shelter, crisis intervention, and comprehensive support services for survivors of human trafficking.', 'București', ['Adăpost de urgență', 'Intervenție și combatere', 'Management de caz', 'Servicii de asistență juridică'], '+40 21 555 0123', 'info@safehaven.ro', 'www.safehaven.ro', '24/7', 'Strada Speranței 12, București', 'Organizații neguvernamentale'],
            ['Freedom Project', 'Specialized services for child trafficking survivors including therapeutic programs, educational support, and family reunification.', 'Cluj', ['Servicii de consiliere psihologică și psihoterapie', 'Training și educație', 'Management de caz', 'Servicii de cazare pe termen lung'], '+40 264 555 0456', 'contact@freedomproject.ro', 'www.freedomproject.ro', 'Luni-Vineri 9:00-18:00', 'Calea Libertății 45, Cluj-Napoca', 'Organizații neguvernamentale'],
            ['Linia de Asistență Națională', 'Confidential, multilingual hotline providing immediate crisis support, referrals, and reporting assistance available nationwide.', 'București', ['Helpline-uri și linii de asistență', 'Intervenție și combatere', 'Servicii de outreach'], '119', 'support@liniadeasistenta.ro', 'www.liniadeasistenta.ro', '24/7', 'Sediu central, București', 'Instituții publice'],
            ['Centrul de Recuperare și Sănătate Mintală', 'Trauma-informed mental health services, substance abuse treatment, and holistic healing programs for trafficking survivors.', 'Iași', ['Servicii de consiliere psihologică și psihoterapie', 'Servicii medicale', 'Management de caz'], '+40 232 555 0789', 'heal@centrurecuperare.ro', 'www.centrurecuperare.ro', 'Luni-Sâmbătă 8:00-20:00', 'Bulevardul Independenței 78, Iași', 'Organizații neguvernamentale'],
            ['Avocați pentru Dreptate', 'Free legal representation for trafficking survivors including immigration relief, criminal record expungement, and civil litigation.', 'Timișoara', ['Servicii de asistență juridică', 'Advocacy', 'Intervenție și combatere'], '+40 256 555 0234', 'legal@avocatidrepate.ro', 'www.avocatijustitie.ro', 'Luni-Vineri 9:00-17:00', 'Strada Justiției 21, Timișoara', 'Organizații neguvernamentale'],
            ['Casa de Tranziție - Noi Începuturi', 'Safe transitional housing with life skills training, job placement assistance, and ongoing support for survivors rebuilding their lives.', 'Brașov', ['Servicii de cazare pe termen lung', 'Consiliere vocațională și acces pe piața muncii', 'Management de caz'], '+40 268 555 0567', 'housing@noiinceputuri.ro', 'www.noiinceputuri.ro', 'Luni-Vineri 8:00-18:00', 'Strada Renașterii 34, Brașov', 'Organizații neguvernamentale'],
            ['Alianța pentru Tineret', 'Prevention programs, street outreach, and survivor-led support groups specifically designed for at-risk and trafficked youth.', 'Constanța', ['Programe de prevenire', 'Servicii de outreach', 'Training și educație'], '+40 241 555 0890', 'youth@aliantatineret.ro', 'www.aliantatineret.ro', 'Luni-Vineri 10:00-19:00', 'Bulevardul Tomis 56, Constanța', 'Organizații neguvernamentale'],
            ['Clinica Medicală Speranță', 'Comprehensive healthcare services including trauma care, reproductive health, and ongoing medical support for trafficking survivors.', 'Galați', ['Servicii medicale', 'Servicii de consiliere psihologică și psihoterapie'], '+40 236 555 0345', 'clinic@clinicasperanta.ro', 'www.clinicasperanta.ro', 'Marți-Sâmbătă 9:00-17:00', 'Strada Sănătății 89, Galați', 'Organizații neguvernamentale'],
            ['Centrul de Orientare Profesională', 'Job training, career counseling, and employment placement services helping survivors achieve economic independence.', 'Sibiu', ['Consiliere vocațională și acces pe piața muncii', 'Training și educație'], '+40 269 555 0678', 'careers@orientareprofesionala.ro', 'www.orientareprofesionala.ro', 'Luni-Vineri 9:00-17:00', 'Piața Unirii 5, Sibiu', 'Instituții publice'],
            ['Rețeaua de Suport Intercultural', 'Culturally-specific services for immigrant and refugee trafficking survivors with multilingual staff and community-based support.', 'Cluj', ['Servicii de traducere și interpretariat', 'Management de caz', 'Servicii de asistență juridică'], '+40 264 555 0901', 'support@reteasaintercult.ro', 'www.reteasaintercult.ro', 'Luni-Vineri 8:00-18:00', 'Strada Interculturală 12, Cluj-Napoca', 'Grupuri de sprijin'],
            ['Centrul pentru Protecția Copilului', 'Child-friendly forensic interviews, medical exams, and coordinated response for child trafficking cases with law enforcement partnership.', 'București', ['Intervenție și combatere', 'Servicii medicale', 'Servicii de asistență juridică', 'Management de caz'], '+40 21 555 0123', 'advocacy@protectiacopilului.ro', 'www.protectiacopilului.ro', 'Luni-Vineri 8:00-17:00', 'Bulevardul Copilăriei 7, București', 'Instituții publice'],
            ['Rețeaua Supraviețuitorilor', 'Survivor-led organization offering peer mentorship, advocacy training, and leadership development opportunities.', 'Iași', ['Activități de voluntariat', 'Advocacy', 'Training și educație'], '+40 232 555 0456', 'unite@reteasasupravietuitori.ro', 'www.reteasasupravietuitori.ro', 'Luni-Joi 10:00-18:00', 'Strada Curajului 8, Iași', 'Grupuri de sprijin'],
            ['Coaliția Comunitară Anti-Trafic', 'Community-based emergency assistance, awareness campaigns, and volunteer mobilization to combat trafficking in local neighborhoods.', 'Oradea', ['Adăpost de urgență', 'Activități de voluntariat', 'Programe de prevenire'], '+40 259 555 0789', 'coalition@coalitiaantitrafic.ro', 'www.coalitiaantitrafic.ro', '24/7', 'Strada Comunității 23, Oradea', 'Organizații neguvernamentale'],
            ['Grupul de Lucru Interinstituțional', 'Multi-agency collaboration coordinating law enforcement, prosecution, and victim services across regional jurisdictions.', 'București', ['Intervenție și combatere', 'Training și educație', 'Advocacy'], '+40 21 555 0234', 'taskforce@grupinterinstitutional.gov.ro', 'www.grupinterinstitutional.gov.ro', 'Luni-Vineri 8:00-17:00', 'Piața Victoriei 1, București', 'Instituții publice'],
            ['Proiectul Siguranță Digitală', 'Technology safety planning, online exploitation prevention, and digital forensics support for trafficking cases involving technology.', 'Cluj', ['Programe de prevenire', 'Training și educație', 'Intervenție și combatere'], '+40 264 555 0567', 'digital@sigurantadigitala.ro', 'www.sigurantadigitala.ro', 'Luni-Vineri 9:00-18:00', 'Strada Tehnologiei 15, Cluj-Napoca', 'Companii/Societăți'],
            ['Unitatea Mobilă de Intervenție', 'Mobile crisis response team providing immediate on-site intervention, assessment, and emergency services throughout the region.', 'Timișoara', ['Adăpost de urgență', 'Intervenție și combatere', 'Servicii de outreach'], '+40 256 555 0890', 'mobile@unitatemobila.ro', 'www.unitatemobila.ro', '24/7', 'Zona Metropolitană Timișoara', 'Instituții publice'],
        ];

        $organizationTypes = [
            'Organizații neguvernamentale' => OrganizationType::Ngo,
            'Instituții publice' => OrganizationType::PublicInstitution,
            'Companii/Societăți' => OrganizationType::Other,
            'Grupuri de sprijin' => OrganizationType::Other,
        ];
        $countyCodes = ['București' => 'B', 'Cluj' => 'CJ', 'Iași' => 'IS', 'Timișoara' => 'TM', 'Brașov' => 'BV', 'Constanța' => 'CT', 'Galați' => 'GL', 'Sibiu' => 'SB', 'Oradea' => 'BH'];
        $counties = County::query()->pluck('id', 'code');

        foreach ($organizations as [$name, $description, $city, $services, $phone, $email, $website, $hours, $address, $type]) {
            Organization::query()->updateOrCreate(
                ['name' => $name],
                [
                    'description_ro' => $description,
                    'description_en' => $description,
                    'city' => $city,
                    'county_id' => $counties->get($countyCodes[$city] ?? ''),
                    'organization_type' => $organizationTypes[$type]->value,
                    'services' => $services,
                    'phone' => $phone,
                    'email' => $email,
                    'website' => $website,
                    'hours' => $hours,
                    'address' => $address,
                    'is_published' => true,
                ],
            );
        }
    }
}
