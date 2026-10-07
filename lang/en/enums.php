<?php

return [
    'user_role' => [
        'admin' => 'Administrator',
        'editor' => 'Editor',
        'professional' => 'Professional',
        'mai' => 'MAI',
        'ngo' => 'NGO',
    ],
    'professional_role' => [
        'social_worker' => 'Social Worker',
        'healthcare_provider' => 'Healthcare Provider',
        'educator' => 'Educator',
        'law_enforcement' => 'Law Enforcement',
        'counselor' => 'Counselor/Therapist',
        'case_manager' => 'Case Manager',
        'legal_professional' => 'Legal Professional',
        'other' => 'Other Child Protection Professional',
    ],
    'resource_type' => [
        'guide' => 'Guides and presentations',
        'document' => 'Documents',
        'video' => 'Videos',
        'printable' => 'Printables',
        'online' => 'Online / social media',
        'curriculum' => 'Curricula and training materials',
    ],
    'account_approval_status' => [
        'pending' => 'Pending',
        'approved' => 'Approved',
        'rejected' => 'Rejected',
    ],
    'resource_access' => [
        'public' => 'Public',
        'ngo' => 'NGO',
        'mai' => 'MAI',
    ],
    'resource_status' => ['draft' => 'Draft', 'published' => 'Published'],
    'partnership_entity_type' => [
        'public_institution' => 'Public institution',
        'ngo' => 'NGO',
        'private_company' => 'Private company',
    ],
    'organization_type' => [
        'public_institution' => 'Public institutions',
        'ngo' => 'Non-governmental organizations',
        'company' => 'Companies',
        'support_group' => 'Support groups',
    ],
    'submission_status' => ['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'],
    'consultation_status' => ['open' => 'Open', 'in_progress' => 'In progress', 'closed' => 'Closed'],
    'consultation_urgency' => ['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'],
    'chart_type' => ['bar' => 'Bar', 'line' => 'Line', 'pie' => 'Pie', 'area' => 'Area'],
    'index_type' => [
        'vulnerability' => 'Structural Vulnerability',
        'resilience' => 'Institutional Resilience',
        'rti' => 'Risk of Trafficking Activity',
    ],
];
