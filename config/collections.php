<?php

/**
 * Collections define the content shape for Anyo at Disenyo.
 *
 * Routing note (PebbleStack): a collection's list route (the path prefix of
 * its `route`, e.g. /work for /work/{slug}) renders its `list_template`
 * even when the collection has no entries yet. We use that to ship the five
 * standalone pages of the site map (Home is the `/` route) as real,
 * crawlable URLs without needing seeded content:
 *   /work     -> projects.list_template     (work.twig)
 *   /services -> services.list_template      (services.twig)
 *   /about    -> about.list_template         (about.twig)
 *   /contact  -> contact_page.list_template  (contact.twig)
 * The `contact` form collection (is_form) stays separate; it only exposes
 * POST /forms/contact and never a public page route.
 */

return [

    'pages' => [
        'label'          => 'Pages',
        'label_singular' => 'Page',
        'icon'           => 'file',
        'route'          => '/{slug}',
        'template'       => 'page.twig',
        'order_by'       => 'updated_at DESC',
        'fields' => [
            'title'            => ['type' => 'text', 'required' => true, 'label' => 'Title'],
            'slug'             => ['type' => 'slug', 'required' => true, 'label' => 'Slug', 'help' => 'URL path, lowercase letters, numbers, dashes.'],
            'body'             => ['type' => 'markdown', 'label' => 'Body', 'help' => 'Markdown supported.'],
            'meta_description' => ['type' => 'textarea', 'label' => 'Meta description', 'help' => 'Used in <meta name="description">. ~160 chars.'],
        ],
    ],

    // Portfolio — the core conversion asset. The firm adds/edits project
    // entries here; /work lists them, /work/{slug} renders a detail page.
    'projects' => [
        'label'          => 'Projects',
        'label_singular' => 'Project',
        'icon'           => 'image',
        'route'          => '/work/{slug}',
        'template'       => 'project.twig',
        'list_template'  => 'work.twig',
        'order_by'       => 'updated_at DESC',
        'list_limit'     => 100,
        'fields' => [
            'title'     => ['type' => 'text', 'required' => true, 'label' => 'Title'],
            'slug'      => ['type' => 'slug', 'required' => true, 'label' => 'Slug'],
            'location'  => ['type' => 'text', 'label' => 'Location'],
            'scope'     => ['type' => 'text', 'label' => 'Scope', 'help' => 'e.g. Residential design + construction documents'],
            'year'      => ['type' => 'number', 'label' => 'Year'],
            'status'    => ['type' => 'select', 'label' => 'Status', 'options' => ['Concept', 'In design', 'In construction', 'Completed']],
            'summary'   => ['type' => 'textarea', 'label' => 'Summary'],
            'body'      => ['type' => 'markdown', 'label' => 'Body'],
            'image'     => ['type' => 'url', 'label' => 'Render image', 'help' => 'URL from /admin/media'],
            'image_alt' => ['type' => 'text', 'label' => 'Image alt text'],
        ],
    ],

    // Services — editable scope rows so a non-technical firm can refine the
    // offering. /services renders the full Services page (list_template).
    'services' => [
        'label'          => 'Services',
        'label_singular' => 'Service',
        'icon'           => 'list',
        'route'          => '/services/{slug}',
        'template'       => 'service.twig',
        'list_template'  => 'services.twig',
        'order_by'       => 'sort ASC',
        'list_limit'     => 100,
        'fields' => [
            'title'   => ['type' => 'text', 'required' => true, 'label' => 'Title'],
            'summary' => ['type' => 'textarea', 'label' => 'Summary'],
            'sort'    => ['type' => 'number', 'label' => 'Order'],
        ],
    ],

    // Single-page collections — their list route IS the page. No entries are
    // needed; the template carries the branded copy directly.
    'about' => [
        'label'          => 'About Page',
        'label_singular' => 'About',
        'icon'           => 'info',
        'route'          => '/about/{slug}',
        'list_template'  => 'about.twig',
        'fields' => [
            'title' => ['type' => 'text', 'required' => true, 'label' => 'Title'],
            'slug'  => ['type' => 'slug', 'required' => true, 'label' => 'Slug'],
            'body'  => ['type' => 'markdown', 'label' => 'Body'],
        ],
    ],

    'contact_page' => [
        'label'          => 'Contact Page',
        'label_singular' => 'Contact Page',
        'icon'           => 'mail',
        'route'          => '/contact/{slug}',
        'list_template'  => 'contact.twig',
        'fields' => [
            'title' => ['type' => 'text', 'required' => true, 'label' => 'Title'],
            'slug'  => ['type' => 'slug', 'required' => true, 'label' => 'Slug'],
            'body'  => ['type' => 'markdown', 'label' => 'Body'],
        ],
    ],

    // Consultation inquiry form — public POST /forms/contact endpoint.
    'contact' => [
        'label'          => 'Consultation Inquiries',
        'label_singular' => 'Inquiry',
        'is_form'        => true,
        'fields' => [
            'name'         => ['type' => 'text', 'required' => true, 'label' => 'Name'],
            'email'        => ['type' => 'text', 'required' => true, 'label' => 'Email'],
            'phone'        => ['type' => 'text', 'label' => 'Phone'],
            'location'     => ['type' => 'text', 'label' => 'Project location'],
            'project_type' => ['type' => 'select', 'label' => 'Project type', 'options' => ['New residential', 'Renovation', 'Commercial', 'Construction documents', 'Other']],
            'message'      => ['type' => 'textarea', 'required' => true, 'label' => 'Message'],
        ],
    ],

];
