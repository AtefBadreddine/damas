@extends('admin.layouts.app', ["app_title" => "Quick Menu"])
@section('main_content')
<?php
$menuLanguages = array(
    'ar' => array('label' => 'Arabic', 'native' => 'العربية', 'direction' => 'rtl'),
    'en' => array('label' => 'English', 'native' => 'English', 'direction' => 'ltr'),
    'fr' => array('label' => 'French', 'native' => 'Français', 'direction' => 'ltr'),
    'fa' => array('label' => 'Persian', 'native' => 'فارسی', 'direction' => 'rtl'),
    'ru' => array('label' => 'Russian', 'native' => 'Русский', 'direction' => 'ltr')
);
$selectedMenuId = isset($menu) && $menu ? (int) $menu->id : 0;
$allMenuItems = Helper::query("Menu", "orderByPlacement")->toArray();
$inlineEditorHtml = '';
if ($selectedMenuId) {
    ob_start();
    ?>
    <div class="sm-editor sm-inline-editor">
        <h4 class="sm-editor-title">Edit selected link</h4>
        <?= Form::open(); ?>
        @include("admin.apparence.partials.links", ['menu_new' => false, 'menu_own_form' => false, 'is_quick_menu_page' => true])
        <?= Form::close(); ?>
    </div>
    <?php
    $inlineEditorHtml = ob_get_clean();
}
?>
<style>
#admin-menu-manager { border-top: 3px solid #14858a; border-radius: 8px; }
#admin-menu-manager .box-header { padding: 20px 24px; }
#admin-menu-manager .box-title { font-size: 20px; font-weight: 600; }
#admin-menu-manager .box-body { padding: 20px 24px 24px; }
#admin-menu-manager .sm-editor { margin-top: 24px; padding: 18px; border: 1px solid #13aaa8; border-radius: 8px; background: #d2f5f2; }
#admin-menu-manager .sm-editor::after { content: ""; display: table; clear: both; }
#admin-menu-manager .sm-editor-title { margin: 0 0 16px; font-size: 16px; font-weight: 600; color: #000; }
#admin-menu-manager .sm-editor label { color: #334155; }
#admin-menu-manager .sm-editor .help-block { color: #475569; }
#admin-menu-manager .sm-tabs { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid #e2e7ed; direction: ltr; }
#admin-menu-manager .sm-tab { display: flex; align-items: center; gap: 9px; padding: 10px 16px; border: 1px solid #dbe2e9; border-radius: 7px; background: #fff; color: #475569; font: inherit; line-height: 1.4; cursor: pointer; }
#admin-menu-manager .sm-tab:hover { background: #f0f8f8; border-color: #14858a; }
#admin-menu-manager .sm-tab.is-active { background: #14858a; border-color: #14858a; color: #fff; }
#admin-menu-manager .sm-tab:focus { outline: 2px solid #14858a; outline-offset: 3px; }
#admin-menu-manager .sm-tab-code { font-size: 11px; font-weight: 700; letter-spacing: .5px; opacity: .8; }
#admin-menu-manager .sm-pane { display: none; }
#admin-menu-manager .sm-pane.is-active { display: block; }
#admin-menu-manager .sm-pane-title { margin: 0 0 18px; color: #334155; font-size: 17px; font-weight: 600; }
#admin-menu-manager .sm-tree { padding: 18px; border: 1px solid #e2e7ed; border-radius: 8px; background: #f8fafc; }
#admin-menu-manager .sm-tree .list-group { list-style: none; padding: 0; margin: 0; }
#admin-menu-manager .sm-tree .list-group .list-group { margin: 8px 0 16px 24px; padding-left: 14px; border-left: 2px solid #dbe2e9; }
#admin-menu-manager .sm-tree[dir="rtl"] .list-group .list-group { margin: 8px 24px 16px 0; padding-left: 0; padding-right: 14px; border-left: 0; border-right: 2px solid #dbe2e9; }
#admin-menu-manager .sm-tree .list-group-item { display: flex; align-items: center; justify-content: space-between; gap: 16px; position: relative; min-height: 52px; margin: 0 0 8px; padding: 10px 14px; border: 1px solid #dbe2e9; border-radius: 6px; background: #fff; color: #334155; line-height: 1.6; overflow-wrap: anywhere; text-align: start; }
#admin-menu-manager .sm-tree .list-group-item:hover { border-color: #a6c9cb; background: #fcfefe; }
#admin-menu-manager .sm-tree .list-group-item.is-editing,
#admin-menu-manager .sm-tree .list-group-item.is-editing:hover { border-color: #14858a; background: #d2f5f2; color: #0f5f63; font-weight: 600; box-shadow: inset 4px 0 0 #14858a; }
#admin-menu-manager .sm-tree[dir="rtl"] .list-group-item.is-editing { box-shadow: inset -4px 0 0 #14858a; }
#admin-menu-manager .sm-lang-badge { display: inline-block; margin-right: 6px; padding: 2px 7px; border-radius: 4px; background: #e2e7ed; color: #475569; font-size: 10px; font-weight: 700; letter-spacing: .4px; vertical-align: middle; }
#admin-menu-manager .sm-editing-badge { padding: 3px 8px; border-radius: 12px; background: #14858a; color: #fff; font-size: 11px; font-weight: 600; white-space: nowrap; }
#admin-menu-manager .sm-tree .list-group-item > .pull-left { float: none !important; display: flex; align-items: center; gap: 6px; flex: 0 0 auto; margin: 0 0 0 auto; direction: ltr; }
#admin-menu-manager .sm-tree[dir="rtl"] .list-group-item > .pull-left { margin-left: 0; margin-right: auto; }
#admin-menu-manager .sm-tree .list-group-item > .pull-left form { display: inline-flex; float: none !important; margin: 0; padding: 0; }
#admin-menu-manager .sm-tree .list-group-item > .pull-left .btn { display: inline-flex; align-items: center; justify-content: center; float: none !important; min-width: 32px; height: 32px; margin: 0; padding: 0 9px; border-radius: 5px; line-height: 1; }
#admin-menu-manager .sm-inline-editor-item { display: block; padding: 0; border: 0; background: transparent; margin: 0 0 16px 0; }
#admin-menu-manager .sm-inline-editor { margin: 0; }
#admin-menu-manager .box-header .box-tools { margin-top: 0; }
#admin-menu-manager .sm-tree .list-group-item.sm-row-toggle-close { cursor: pointer; }
#admin-menu-manager .sm-tree .list-group-item .sm-row-label { flex: 1 1 auto; min-width: 0; }
@media (max-width: 600px) {
    #admin-menu-manager .box-header { padding: 16px; }
    #admin-menu-manager .box-body { padding: 16px; }
    #admin-menu-manager .sm-editor, #admin-menu-manager .sm-tree { padding: 12px; }
    #admin-menu-manager .sm-tab { flex: 1 0 auto; justify-content: center; padding: 9px 12px; }
    #admin-menu-manager .sm-tree .list-group-item { gap: 8px; padding: 10px; }
    #admin-menu-manager .sm-tree .list-group .list-group { margin-left: 10px; padding-left: 8px; }
    #admin-menu-manager .sm-tree[dir="rtl"] .list-group .list-group { margin-right: 10px; padding-right: 8px; }
}
</style>

<div class="box" id="admin-menu-manager"
     data-selected-menu-id="<?= $selectedMenuId; ?>"
     data-menu-base-url="<?= e(route(Route::currentRouteName())); ?>">
    <div class="box-header with-border">
        <h3 class="box-title">Manage Lists</h3>
        <div class="box-tools pull-right">
            <a href="<?= route('admin.apparence.menus'); ?>" class="btn btn-success btn-sm" id="sm-new-link-btn">
                <i class="fa fa-plus"></i> New link
            </a>
        </div>
    </div>
    <div class="box-body">
        <section class="sm-pane is-active" id="sm-pane-all">
            <div class="sm-tree" dir="rtl" lang="ar">
                <?= Helper::menu_tree_admin(0, 0, $allMenuItems, 'ar', $selectedMenuId ?: null, $inlineEditorHtml); ?>
            </div>
        </section>

        @if(!$selectedMenuId)
        <div class="sm-editor" id="sm-link-editor">
            <h4 class="sm-editor-title">Add new link</h4>
            <?= Form::open(); ?>
                @include("admin.apparence.partials.links", ['menu_new' => false, 'menu_own_form' => false, 'is_quick_menu_page' => true])
            <?= Form::close(); ?>
        </div>
        @endif
    </div>
</div>

<script>
(function () {
    var manager = document.getElementById('admin-menu-manager');
    if (!manager) return;

    var baseUrl = manager.getAttribute('data-menu-base-url');
    var selectedMenuId = manager.getAttribute('data-selected-menu-id');
    var editor = document.getElementById('sm-inline-editor');
    var createEditor = document.getElementById('sm-link-editor');
    var newLinkBtn = document.getElementById('sm-new-link-btn');

    function placeEditor() {
        if (!editor) return;
        var activePane = manager.querySelector('.sm-pane.is-active');
        if (!activePane) return;
        var row = activePane.querySelector('.list-group-item.is-editing');
        if (!row || row.nextElementSibling === editor) return;
        row.parentNode.insertBefore(editor, row.nextSibling);
    }

    function scrollToElement(el) {
        if (!el) return;
        window.requestAnimationFrame(function () {
            var top = el.getBoundingClientRect().top + window.pageYOffset - 24;
            window.scrollTo({ top: top, behavior: 'smooth' });
        });
    }

    var closeRow = manager.querySelector('.sm-row-toggle-close');
    if (closeRow) {
        closeRow.addEventListener('click', function (event) {
            if (event.target.closest('.sm-row-actions')) return;
            var closeUrl = closeRow.getAttribute('data-menu-close-url') || baseUrl;
            window.location.href = closeUrl;
        });
    }

    if (newLinkBtn && (!selectedMenuId || selectedMenuId === '0')) {
        newLinkBtn.addEventListener('click', function (event) {
            if (this.pathname === window.location.pathname && !window.location.pathname.match(/\/\d+$/)) {
                event.preventDefault();
                scrollToElement(createEditor);
            }
        });
    }

    placeEditor();
    if (editor) {
        if (document.readyState === 'complete') scrollToElement(editor);
        else window.addEventListener('load', function () { scrollToElement(editor); });
    }
})();
</script>
@endsection
