<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use App\Models\AttendanceCategory;
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;


// agenda-items index page
Breadcrumbs::for('agenda-items.index', function (BreadcrumbTrail $trail) {
    $trail->push('Agendapunten', route('agenda-items.index'));
});

// agenda-items index page
Breadcrumbs::for('agenda-items.status', function (BreadcrumbTrail $trail) {
    $trail->push('Agendapunten', '/agenda-items/');
});

// agenda-items create page
Breadcrumbs::for('agenda-items.create', function (BreadcrumbTrail $trail) {
    $trail->parent('agenda-items.index');
    $trail->push('Nieuwe Agendapunt Toevoegen', route('agenda-items.create'));
});

// agenda-items edit page
Breadcrumbs::for('agenda-items.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('agenda-items.index');
    $trail->push('Agendapunt Aanpassen', route('agenda-items.edit'));
});

// agenda-items show page
Breadcrumbs::for('agenda-items.show', function (BreadcrumbTrail $trail) {
    $trail->parent('agenda-items.index');
    $trail->push('Agendapunt Bekijken', route('agenda-items.show'));
});

// attendance index page
Breadcrumbs::for('attendance.index', function (BreadcrumbTrail $trail) {
    $trail->push('Aanwezigheidsrooster', route('attendance.index'));
});

// attendance create page
Breadcrumbs::for('attendance.create', function (BreadcrumbTrail $trail) {
    $trail->parent('attendance.index');
    $trail->push('Nieuwe Aanwezigheid Toevoegen', route('attendance.create'));
});

// attendance edit page
Breadcrumbs::for('attendance.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('attendance.index');
    $trail->push('Aanwezigheid Aanpassen', route('attendance.edit'));
});

// attendance show page
Breadcrumbs::for('attendance.show', function (BreadcrumbTrail $trail) {
    $trail->parent('attendance.index');
    $trail->push('Aanwezigheid Bekijken', route('attendance.show'));
});

// attendance-categories index page
Breadcrumbs::for('attendance-categories.index', function (BreadcrumbTrail $trail) {
    $trail->push('Aanwezigheideidsoverzicht', route('attendance-categories.index'));
});

// attendance-categories create page
Breadcrumbs::for('attendance-categories.create', function (BreadcrumbTrail $trail) {
    $trail->parent('attendance-categories.index');
    $trail->push('Nieuwe Categorie Toevoegen', route('attendance-categories.create'));
});

// attendance-categories edit page
Breadcrumbs::for('attendance-categories.edit', function (BreadcrumbTrail $trail, AttendanceCategory $attendanceCategory) {
    $trail->parent('attendance-categories.index');
    $trail->push('Categorie Aanpassen', route('attendance-categories.edit', $attendanceCategory));
});

// attendance-categories show page
Breadcrumbs::for('attendance-categories.show', function (BreadcrumbTrail $trail) {
    $trail->parent('attendance-categories.index');
    $trail->push('Categorie Bekijken', route('attendance-categories.show'));
});

// attendance-employees index page
Breadcrumbs::for('attendance-employees.index', function (BreadcrumbTrail $trail) {
    $trail->push('Aanwezigheid Medewerkers', route('attendance-employees.index'));
});

// attendance-employees create page
Breadcrumbs::for('attendance-employees.create', function (BreadcrumbTrail $trail) {
    $trail->parent('attendance-employees.index');
    $trail->push('Nieuwe Medewerker Toevoegen', route('attendance-employees.create'));
});

// attendance-employees edit page
Breadcrumbs::for('attendance-employees.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('attendance-employees.index');
    $trail->push('Medewerker Aanpassen', route('attendance-employees.edit'));
});

// attendance-employees show page
Breadcrumbs::for('attendance-employees.show', function (BreadcrumbTrail $trail) {
    $trail->parent('attendance-employees.index');
    $trail->push('Medewerker Bekijken', route('attendance-employees.show'));
});

// borrowed-equipment index page
Breadcrumbs::for('borrowed-equipments.index', function (BreadcrumbTrail $trail) {
    $trail->push('Hardware Uitlenen', route('borrowed-equipments.index'));
});

// borrowed-equipment index page
Breadcrumbs::for('borrowed-equipments.list', function (BreadcrumbTrail $trail) {
    $trail->push('Leenlaptops Uitlenen', '/');
});

// borrowed-equipment create page
Breadcrumbs::for('borrowed-equipments.create', function (BreadcrumbTrail $trail) {
    $trail->parent('borrowed-equipments.index');
    $trail->push('Hardware uitlenen', route('borrowed-equipments.create'));
});

// borrowed-equipment edit page
Breadcrumbs::for('borrowed-equipments.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('borrowed-equipments.index');
    $trail->push('Uitgeleende Hardware Aanpassen', route('borrowed-equipments.edit'));
});


// employee-departments index page
Breadcrumbs::for('employee-departments.index', function (BreadcrumbTrail $trail) {
    $trail->push('Aanwezigheid Afdelingen', route('employee-departments.index'));
});

// employee-departments create page
Breadcrumbs::for('employee-departments.create', function (BreadcrumbTrail $trail) {
    $trail->parent('employee-departments.index');
    $trail->push('Nieuwe Afdeling Toevoegen', route('employee-departments.create'));
});

// employee-departments edit page
Breadcrumbs::for('employee-departments.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('employee-departments.index');
    $trail->push('Afdeling Aanpassen', route('employee-departments.edit'));
});

// employee-departments show page
Breadcrumbs::for('employee-departments.show', function (BreadcrumbTrail $trail) {
    $trail->parent('employee-departments.index');
    $trail->push('Afdeling Bekijken', route('employee-departments.show'));
});

// menu-item index page
Breadcrumbs::for('menu-item.index', function (BreadcrumbTrail $trail) {
    $trail->push('Menu Items', route('menu-item.index'));
});

// menu-item create page
Breadcrumbs::for('menu-item.create', function (BreadcrumbTrail $trail) {
    $trail->parent('menu-item.index');
    $trail->push('Menu Item Toevoegen', route('menu-item.create'));
});

// menu-item edit page
Breadcrumbs::for('menu-item.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('menu-item.index');
    $trail->push('Menu Item Aanpassen', route('menu-item.edit'));
});

// menu-item show page
Breadcrumbs::for('menu-item.show', function (BreadcrumbTrail $trail) {
    $trail->parent('menu-item.index');
    $trail->push('Menu Item Bekijken', route('menu-item.show'));
});

// notification index page
Breadcrumbs::for('notifications.index', function (BreadcrumbTrail $trail) {
    $trail->push('Wallboard Meldingen Overzicht', route('notifications.index'));
});

// notification create page
Breadcrumbs::for('notifications.create', function (BreadcrumbTrail $trail) {
    $trail->parent('notifications.index');
    $trail->push('Nieuwe wallboard melding maken', route('notifications.create'));
});

// notification edit page
Breadcrumbs::for('notifications.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('notifications.index');
    $trail->push('Melding Wijzigen', '/notifications/');
});

// notification show page
Breadcrumbs::for('notifications.show', function (BreadcrumbTrail $trail) {
    $trail->parent('notifications.index');
    $trail->push('Wallboard Melding Bekijken', route('notifications.show'));
});

// problems index page
Breadcrumbs::for('problems.index', function (BreadcrumbTrail $trail) {
    $trail->push('Lopende Problemen', route('problems.index'));
});

// problems create page
Breadcrumbs::for('problems.create', function (BreadcrumbTrail $trail) {
    $trail->parent('problems.index');
    $trail->push('Nieuw Probleem Toevoegen', route('problems.create'));
});

// problems edit page
Breadcrumbs::for('problems.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('problems.index');
    $trail->push('Probleem Aanpassen', route('problems.edit'));
});

// problems show page
Breadcrumbs::for('problems.show', function (BreadcrumbTrail $trail) {
    $trail->parent('problems.index');
    $trail->push('Probleem Bekijken', route('problems.show'));
});

// users index page
Breadcrumbs::for('users.index', function (BreadcrumbTrail $trail) {
    $trail->push('Gebruikers', route('users.index'));
});

// users create page
Breadcrumbs::for('users.create', function (BreadcrumbTrail $trail) {
    $trail->parent('users.index');
    $trail->push('Nieuwe Gebruiker Toevoegen', route('users.create'));
});

// users edit page
Breadcrumbs::for('users.edit', function (BreadcrumbTrail $trail) {
    $trail->parent('users.index');
    $trail->push('Gebruiker Aanpassen', route('users.edit'));
});

// users show page
Breadcrumbs::for('users.show', function (BreadcrumbTrail $trail) {
    $trail->parent('users.index');
    $trail->push('Gebruiker Bekijken', route('users.show'));
});
