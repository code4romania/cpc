<?php

return [
    'user_role' => [
        'admin' => 'Administrator',
        'editor' => 'Editor',
        'professional' => 'Profesionist',
    ],
    'professional_role' => [
        'social_worker' => 'Asistent social',
        'healthcare_provider' => 'Furnizor de servicii medicale',
        'educator' => 'Educator',
        'law_enforcement' => 'Forțe de ordine',
        'counselor' => 'Consilier/Terapeut',
        'case_manager' => 'Manager de caz',
        'legal_professional' => 'Profesionist juridic',
        'other' => 'Alt profesionist în protecția copilului',
    ],
    'resource_type' => [
        'guide' => 'Ghid', 'document' => 'Document', 'video' => 'Video',
        'printable' => 'Material printabil', 'template' => 'Șablon', 'material' => 'Material',
    ],
    'resource_status' => ['draft' => 'Schiță', 'published' => 'Publicat'],
    'organization_type' => [
        'ngo' => 'ONG', 'public_institution' => 'Instituție publică',
        'international' => 'Organizație internațională', 'other' => 'Altul',
    ],
    'submission_status' => ['pending' => 'În așteptare', 'approved' => 'Aprobat', 'rejected' => 'Respins'],
    'consultation_status' => ['open' => 'Deschisă', 'in_progress' => 'În lucru', 'closed' => 'Închisă'],
    'consultation_urgency' => ['low' => 'Scăzută', 'medium' => 'Medie', 'high' => 'Ridicată'],
    'chart_type' => ['bar' => 'Bare', 'line' => 'Linie', 'pie' => 'Circular', 'area' => 'Arie'],
    'index_type' => [
        'vulnerability' => 'Vulnerabilitate structurală',
        'resilience' => 'Reziliență instituțională',
        'rti' => 'Risc activitate trafic',
    ],
];
