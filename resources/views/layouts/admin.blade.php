<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('page-title', 'Admin') | Raab Shoes</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700,800" rel="stylesheet" />

        <style>
            :root {
                --panel: #ffffff;
                --sidebar-accent: #ffc98f;
                --orange: #f57c00;
                --text: #141414;
                --muted: #8d8d94;
                --blue-soft: #7f8fc2;
                --shadow: 0 16px 34px rgba(87, 66, 36, 0.12);
                --border-soft: rgba(232, 223, 208, 0.9);
                --bg-start: #fbfaf6;
                --bg-end: #f7f3ea;
                --topbar-bg: rgba(255, 255, 255, 0.96);
                --sidebar-bg: #fffefe;
                --icon-color: #1d1d1f;
                --pill-bg: #fffefe;
                --notif-bg: #ffffff;
                --notif-border: rgba(232, 223, 208, 0.92);
            }

            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                min-height: 100vh;
                font-family: 'Poppins', sans-serif;
                color: var(--text);
                color-scheme: light;
                background:
                    radial-gradient(circle at top center, rgba(255, 217, 163, 0.16), transparent 22%),
                    linear-gradient(180deg, var(--bg-start) 0%, var(--bg-end) 100%);
                transition: background-color 0.25s ease, color 0.25s ease;
            }

            body.theme-dark {
                --panel: #1d232d;
                --sidebar-accent: #d69a61;
                --text: #f7f3eb;
                --muted: #a4a9b3;
                --blue-soft: #b4bdea;
                --shadow: 0 18px 36px rgba(0, 0, 0, 0.34);
                --border-soft: rgba(76, 86, 100, 0.65);
                --bg-start: #151922;
                --bg-end: #0d1017;
                --topbar-bg: rgba(26, 31, 41, 0.96);
                --sidebar-bg: #171c25;
                --icon-color: #f5f1e8;
                --pill-bg: #1c222c;
                --notif-bg: #1d232d;
                --notif-border: rgba(81, 91, 106, 0.7);
                color-scheme: dark;
            }

            a {
                color: inherit;
                text-decoration: none;
            }

            button,
            input,
            select,
            textarea {
                font: inherit;
            }

            .admin-shell {
                display: grid;
                grid-template-columns: 320px 1fr;
                min-height: 100vh;
            }

            .sidebar {
                background: var(--sidebar-bg);
                border-right: 1px solid var(--border-soft);
                box-shadow: 8px 0 22px rgba(62, 43, 14, 0.06);
                display: flex;
                flex-direction: column;
            }

            .sidebar-brand {
                height: 168px;
                padding: 34px;
                border-radius: 0 0 32px 0;
                background: var(--sidebar-accent);
                box-shadow: 0 14px 26px rgba(122, 81, 12, 0.12);
            }

            .brand {
                display: inline-flex;
                align-items: center;
            }

            .brand-logo {
                display: block;
                width: 210px;
                height: auto;
            }

            .sidebar-nav {
                padding: 34px 20px;
            }

            .nav-list {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }

            .nav-item {
                position: relative;
                display: flex;
                align-items: center;
                gap: 14px;
                min-height: 54px;
                padding: 0 16px;
                border-radius: 18px;
                color: #9d9da3;
                font-size: 1rem;
                font-weight: 500;
                transition: transform 0.18s ease, background-color 0.18s ease, color 0.18s ease, box-shadow 0.18s ease;
            }

            .nav-item svg {
                width: 22px;
                height: 22px;
                flex-shrink: 0;
            }

            .nav-item.active {
                color: #2d2d2f;
                font-weight: 700;
            }

            .nav-item:hover,
            .nav-item:focus-visible {
                transform: translateX(3px);
                background: rgba(245, 124, 0, 0.09);
                color: #2d2d2f;
                outline: none;
            }

            .nav-item.active svg {
                color: var(--orange);
            }

            .nav-item.active::after {
                content: '';
                position: absolute;
                top: 7px;
                bottom: 7px;
                right: 12px;
                width: 4px;
                border-radius: 999px;
                background: var(--orange);
            }

            .main {
                padding-bottom: 40px;
            }

            .topbar {
                margin: 0 0 26px;
                padding: 28px 46px;
                background: var(--topbar-bg);
                border-radius: 0 0 28px 28px;
                box-shadow: 0 10px 30px rgba(89, 68, 37, 0.12);
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 24px;
            }

            .headline {
                margin: 0;
                font-size: clamp(1.9rem, 4vw, 2.3rem);
                font-weight: 700;
                letter-spacing: -0.04em;
            }

            .subheadline {
                margin: 6px 0 0;
                font-size: 0.98rem;
                color: var(--blue-soft);
                font-weight: 500;
            }

            .topbar-actions {
                display: flex;
                align-items: center;
                gap: 16px;
                position: relative;
            }

            .icon-btn {
                width: 56px;
                height: 56px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border: 1px solid transparent;
                padding: 0;
                border-radius: 16px;
                background: transparent;
                color: var(--icon-color);
                flex-shrink: 0;
                line-height: 1;
                cursor: pointer;
                transition: transform 0.18s ease, background-color 0.18s ease, color 0.18s ease;
            }

            .icon-btn svg {
                width: 30px;
                height: 30px;
                display: block;
            }

            .icon-btn:hover,
            .icon-btn:focus-visible {
                background: rgba(245, 124, 0, 0.1);
                border-color: rgba(245, 124, 0, 0.2);
                outline: none;
            }

            .icon-btn:active {
                transform: translateY(1px);
            }

            .icon-btn[data-active='true'] {
                background: rgba(245, 124, 0, 0.14);
            }

            .notification-btn {
                position: relative;
            }

            .notification-menu {
                position: relative;
            }

            .notification-dot {
                position: absolute;
                top: 12px;
                right: 13px;
                width: 11px;
                height: 11px;
                border-radius: 999px;
                background: var(--orange);
                box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.92);
            }

            body.theme-dark .notification-dot {
                box-shadow: 0 0 0 4px rgba(28, 34, 44, 0.96);
            }

            .admin-pill {
                min-width: 206px;
                height: 56px;
                padding: 0 16px 0 24px;
                border-radius: 18px;
                border: 3px solid var(--orange);
                display: inline-flex;
                align-items: center;
                justify-content: flex-end;
                gap: 18px;
                font-size: 1.08rem;
                font-weight: 700;
                background: var(--pill-bg);
                line-height: 1;
                box-sizing: border-box;
                cursor: pointer;
                color: var(--text);
                transition: transform 0.18s ease, box-shadow 0.18s ease, background-color 0.18s ease;
                position: relative;
            }

            .admin-menu {
                position: relative;
            }

            .admin-pill:hover,
            .admin-pill:focus-visible {
                box-shadow: 0 10px 20px rgba(245, 124, 0, 0.14);
                outline: none;
            }

            .admin-pill:active {
                transform: translateY(1px);
            }

            .admin-pill span {
                position: absolute;
                left: 50%;
                transform: translateX(-50%);
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
                max-width: calc(100% - 76px);
                text-align: center;
            }

            .admin-pill svg {
                width: 30px;
                height: 30px;
                color: #55565c;
                flex-shrink: 0;
                transition: transform 0.18s ease, color 0.18s ease;
            }

            body.theme-dark .admin-pill svg {
                color: #e7ebf2;
            }

            .admin-pill[data-active='true'] svg {
                transform: rotate(180deg);
            }

            .admin-menu-panel {
                position: absolute;
                top: calc(100% + 12px);
                right: 0;
                width: 260px;
                padding: 14px;
                border-radius: 22px;
                background: var(--notif-bg);
                border: 1px solid var(--notif-border);
                box-shadow: var(--shadow);
                display: none;
                z-index: 20;
            }

            .admin-menu-panel.is-open {
                display: block;
            }

            .admin-menu-info {
                padding: 12px 14px 14px;
                border-radius: 16px;
                background: rgba(245, 124, 0, 0.08);
            }

            .admin-menu-name {
                display: block;
                font-size: 0.98rem;
                font-weight: 700;
                color: var(--text);
            }

            .admin-menu-email {
                display: block;
                margin-top: 4px;
                font-size: 0.84rem;
                color: var(--muted);
                word-break: break-word;
            }

            body.theme-dark .admin-menu-info {
                background: rgba(245, 124, 0, 0.14);
            }

            .admin-menu-actions {
                display: grid;
                gap: 10px;
                margin-top: 12px;
            }

            .admin-menu-action {
                width: 100%;
                min-height: 46px;
                padding: 0 14px;
                border: 0;
                border-radius: 14px;
                background: #fff3e2;
                color: var(--orange);
                display: inline-flex;
                align-items: center;
                justify-content: flex-start;
                gap: 10px;
                font-size: 0.92rem;
                font-weight: 700;
                cursor: pointer;
                transition: transform 0.18s ease, background-color 0.18s ease, box-shadow 0.18s ease;
            }

            .admin-menu-action svg {
                width: 20px;
                height: 20px;
                flex-shrink: 0;
            }

            body.theme-dark .admin-menu-action {
                background: #332b22;
                color: #ffd39b;
            }

            .admin-menu-action:hover,
            .admin-menu-action:focus-visible {
                transform: translateY(-1px);
                background: #ffe4c0;
                box-shadow: 0 10px 20px rgba(245, 124, 0, 0.14);
                outline: none;
            }

            body.theme-dark .admin-menu-action:hover,
            body.theme-dark .admin-menu-action:focus-visible {
                background: #443321;
            }

            .notification-panel {
                position: absolute;
                top: calc(100% + 12px);
                right: 0;
                width: 320px;
                padding: 18px;
                border-radius: 24px;
                background: var(--notif-bg);
                border: 1px solid var(--notif-border);
                box-shadow: var(--shadow);
                display: none;
                z-index: 20;
            }

            .notification-panel.is-open {
                display: block;
            }

            .notification-btn[data-active='true'] .notification-dot {
                transform: scale(0.72);
                opacity: 0.7;
            }

            .theme-icon {
                display: block;
            }

            .theme-icon.sun {
                display: none;
            }

            body.theme-dark .theme-icon.moon {
                display: none;
            }

            body.theme-dark .theme-icon.sun {
                display: block;
            }

            .notification-title {
                margin: 0 0 14px;
                font-size: 1rem;
                font-weight: 700;
            }

            .notification-list {
                display: grid;
                gap: 12px;
            }

            .notification-item {
                display: block;
                padding: 14px 16px;
                border-radius: 18px;
                background: rgba(245, 124, 0, 0.08);
                transition: transform 0.18s ease, background-color 0.18s ease, box-shadow 0.18s ease;
            }

            .notification-item:hover,
            .notification-item:focus-visible {
                transform: translateY(-2px);
                background: rgba(245, 124, 0, 0.14);
                box-shadow: 0 10px 20px rgba(245, 124, 0, 0.12);
                outline: none;
            }

            body.theme-dark .notification-item {
                background: rgba(245, 124, 0, 0.14);
            }

            body.theme-dark .notification-item:hover,
            body.theme-dark .notification-item:focus-visible {
                background: rgba(245, 124, 0, 0.22);
            }

            .notification-item strong {
                display: block;
                margin-bottom: 4px;
                font-size: 0.96rem;
            }

            .notification-item span {
                display: block;
                color: var(--muted);
                font-size: 0.88rem;
            }

            .dialog-backdrop {
                position: fixed;
                inset: 0;
                background: rgba(17, 20, 26, 0.44);
                display: none;
                align-items: center;
                justify-content: center;
                padding: 24px;
                z-index: 60;
            }

            .dialog-backdrop.is-open {
                display: flex;
            }

            .dialog-card {
                width: min(100%, 420px);
                padding: 24px;
                border-radius: 28px;
                background: var(--panel);
                color: var(--text);
                box-shadow: var(--shadow);
                border: 1px solid var(--notif-border);
            }

            .dialog-title {
                margin: 0;
                font-size: 1.28rem;
                font-weight: 700;
            }

            .dialog-text {
                margin: 10px 0 0;
                color: var(--muted);
                font-size: 0.95rem;
                line-height: 1.6;
            }

            .dialog-actions {
                display: flex;
                justify-content: flex-end;
                gap: 12px;
                margin-top: 24px;
            }

            .dialog-btn {
                min-width: 132px;
                height: 48px;
                padding: 0 18px;
                border-radius: 16px;
                border: 2px solid transparent;
                font-size: 0.92rem;
                font-weight: 700;
                cursor: pointer;
                transition: transform 0.18s ease, background-color 0.18s ease, border-color 0.18s ease, box-shadow 0.18s ease, filter 0.18s ease;
            }

            .dialog-btn.cancel {
                background: transparent;
                color: var(--text);
                border-color: rgba(245, 124, 0, 0.28);
            }

            .dialog-btn.confirm {
                background: linear-gradient(180deg, #ff8c0d 0%, #f57c00 100%);
                color: #fff;
            }

            .dialog-btn:hover,
            .dialog-btn:focus-visible {
                transform: translateY(-2px);
                outline: none;
            }

            .dialog-btn.cancel:hover,
            .dialog-btn.cancel:focus-visible {
                background: #fff3e2;
                border-color: var(--orange);
                box-shadow: 0 10px 20px rgba(245, 124, 0, 0.12);
            }

            .dialog-btn.confirm:hover,
            .dialog-btn.confirm:focus-visible {
                filter: brightness(1.04) saturate(1.05);
                box-shadow: 0 12px 24px rgba(245, 124, 0, 0.24);
            }

            .dialog-btn:active {
                transform: translateY(1px);
            }

            .icon-btn:disabled,
            .admin-pill:disabled,
            .admin-menu-action:disabled,
            .dialog-btn:disabled,
            .icon-btn[aria-disabled='true'],
            .admin-pill[aria-disabled='true'],
            .admin-menu-action[aria-disabled='true'],
            .dialog-btn[aria-disabled='true'] {
                cursor: not-allowed;
                opacity: 0.48;
                pointer-events: none;
                box-shadow: none;
                transform: none;
                filter: grayscale(0.25);
            }

            .content :is(.primary-btn, .empty-btn, .wa-link, .wa-btn, .edit-link, .edit-btn, .modal-btn, .filter-btn, .export-btn, .save-btn, .add-user-btn, .redeem-btn, .upload-btn, .btn, .back-link, .tab, .filter-trigger) {
                cursor: pointer;
                transition: transform 0.18s ease, box-shadow 0.18s ease, background-color 0.18s ease, border-color 0.18s ease, color 0.18s ease, filter 0.18s ease;
            }

            .content :is(.primary-btn, .empty-btn, .wa-link, .wa-btn, .edit-link, .edit-btn, .modal-btn, .filter-btn, .export-btn, .save-btn, .add-user-btn, .redeem-btn, .upload-btn, .btn, .back-link, .tab, .filter-trigger):hover,
            .content :is(.primary-btn, .empty-btn, .wa-link, .wa-btn, .edit-link, .edit-btn, .modal-btn, .filter-btn, .export-btn, .save-btn, .add-user-btn, .redeem-btn, .upload-btn, .btn, .back-link, .tab, .filter-trigger):focus-visible {
                transform: translateY(-2px);
                outline: none;
            }

            .content :is(.primary-btn, .empty-btn, .edit-btn.save, .modal-btn.save, .modal-btn.submit, .filter-btn.submit, .export-btn, .save-btn, .add-user-btn, .redeem-btn, .upload-btn.primary, .btn-primary):hover,
            .content :is(.primary-btn, .empty-btn, .edit-btn.save, .modal-btn.save, .modal-btn.submit, .filter-btn.submit, .export-btn, .save-btn, .add-user-btn, .redeem-btn, .upload-btn.primary, .btn-primary):focus-visible {
                filter: brightness(1.04) saturate(1.05);
                box-shadow: 0 14px 26px rgba(245, 124, 0, 0.26);
            }

            .content :is(.edit-link, .edit-btn.cancel, .modal-btn.cancel, .filter-btn.reset, .btn-outline, .back-link, .tab, .filter-trigger):hover,
            .content :is(.edit-link, .edit-btn.cancel, .modal-btn.cancel, .filter-btn.reset, .btn-outline, .back-link, .tab, .filter-trigger):focus-visible {
                background: #fff3e2;
                border-color: var(--orange);
                color: var(--orange);
                box-shadow: 0 10px 20px rgba(245, 124, 0, 0.12);
            }

            .content .wa-link:hover,
            .content .wa-link:focus-visible,
            .content .wa-btn:hover,
            .content .wa-btn:focus-visible {
                filter: brightness(1.05) saturate(1.05);
                box-shadow: 0 12px 22px rgba(31, 168, 85, 0.24);
            }

            .content :is(.primary-btn, .empty-btn, .wa-link, .wa-btn, .edit-link, .edit-btn, .modal-btn, .filter-btn, .export-btn, .save-btn, .add-user-btn, .redeem-btn, .upload-btn, .btn, .back-link, .tab, .filter-trigger):active {
                transform: translateY(1px);
            }

            .content :is(.primary-btn, .empty-btn, .wa-link, .wa-btn, .edit-link, .edit-btn, .modal-btn, .filter-btn, .export-btn, .save-btn, .add-user-btn, .redeem-btn, .upload-btn, .btn, .back-link, .tab, .filter-trigger):disabled,
            .content :is(.primary-btn, .empty-btn, .wa-link, .wa-btn, .edit-link, .edit-btn, .modal-btn, .filter-btn, .export-btn, .save-btn, .add-user-btn, .redeem-btn, .upload-btn, .btn, .back-link, .tab, .filter-trigger)[aria-disabled='true'] {
                cursor: not-allowed;
                opacity: 0.48;
                pointer-events: none;
                box-shadow: none;
                transform: none;
                filter: grayscale(0.25);
            }

            body.theme-dark .content .stat-card,
            body.theme-dark .content .panel,
            body.theme-dark .content .notifications,
            body.theme-dark .content .search-panel,
            body.theme-dark .content .empty-state,
            body.theme-dark .content .filter-card,
            body.theme-dark .content .empty-card,
            body.theme-dark .content .form-panel,
            body.theme-dark .content .settings-card,
            body.theme-dark .content .summary-card,
            body.theme-dark .content .service-section,
            body.theme-dark .content .service-card,
            body.theme-dark .content .user-card,
            body.theme-dark .content .chart-card,
            body.theme-dark .content .modal-card,
            body.theme-dark .content .orders-list,
            body.theme-dark .content .history-list,
            body.theme-dark .content .customers-list,
            body.theme-dark .content .order-card,
            body.theme-dark .content .history-card,
            body.theme-dark .content .customer-card,
            body.theme-dark .content .receipt-card,
            body.theme-dark .content .filter-menu {
                background: #202733 !important;
                color: var(--text);
                border-color: rgba(79, 89, 104, 0.9);
                box-shadow: 0 16px 34px rgba(0, 0, 0, 0.28);
            }

            body.theme-dark .content .chart-card {
                background: #1a202b !important;
                border-color: rgba(79, 89, 104, 0.72);
            }

            body.theme-dark .content .search-box,
            body.theme-dark .content .filter-box,
            body.theme-dark .content .filter-trigger,
            body.theme-dark .content .control,
            body.theme-dark .content .input,
            body.theme-dark .content .select,
            body.theme-dark .content .textarea,
            body.theme-dark .content .upload-box,
            body.theme-dark .content .field input,
            body.theme-dark .content .modal-input,
            body.theme-dark .content .modal-textarea {
                background: #161c25 !important;
                color: var(--text) !important;
                border-color: var(--orange) !important;
            }

            body.theme-dark .content .search-box input,
            body.theme-dark .content .control input,
            body.theme-dark .content .field input,
            body.theme-dark .content .input,
            body.theme-dark .content .select,
            body.theme-dark .content .textarea,
            body.theme-dark .content .modal-input,
            body.theme-dark .content .modal-textarea,
            body.theme-dark .content .filter-trigger,
            body.theme-dark .content .filter-option {
                color: var(--text) !important;
            }

            body.theme-dark .content .select option {
                background: #161c25;
                color: var(--text);
            }

            body.theme-dark .content .search-box input::placeholder,
            body.theme-dark .content .control input::placeholder,
            body.theme-dark .content .field input::placeholder,
            body.theme-dark .content .input::placeholder,
            body.theme-dark .content .textarea::placeholder,
            body.theme-dark .content .modal-input::placeholder,
            body.theme-dark .content .modal-textarea::placeholder {
                color: #8e97a8 !important;
            }

            body.theme-dark .content .service-item,
            body.theme-dark .content .info-box,
            body.theme-dark .content .data-row,
            body.theme-dark .content .flash-message {
                background: linear-gradient(180deg, #2a313c 0%, #232a34 100%) !important;
                border-color: rgba(102, 111, 125, 0.75) !important;
            }

            body.theme-dark .content .service-count,
            body.theme-dark .content .role-badge.admin,
            body.theme-dark .content .status-badge,
            body.theme-dark .content .customer-badge {
                background: #332b22 !important;
                color: #ffd39b !important;
            }

            body.theme-dark .content .notification-pill {
                background: #3a2b1f !important;
                color: #ffe4bf !important;
            }

            body.theme-dark .content .chart-area {
                background:
                    linear-gradient(180deg, transparent 0 94%, rgba(91, 104, 139, 0.24) 94% 95%, transparent 95%),
                    repeating-linear-gradient(180deg, transparent 0 41px, rgba(91, 104, 139, 0.22) 41px 43px),
                    #121821 !important;
            }

            body.theme-dark .content .chart-header,
            body.theme-dark .content .chart-legend,
            body.theme-dark .content .service-meta,
            body.theme-dark .content .empty-text,
            body.theme-dark .content .panel-empty,
            body.theme-dark .content .user-meta,
            body.theme-dark .content .order-meta,
            body.theme-dark .content .history-meta,
            body.theme-dark .content .customer-meta,
            body.theme-dark .content .receipt-label,
            body.theme-dark .content .preview-help,
            body.theme-dark .content .ghost,
            body.theme-dark .content .card-note,
            body.theme-dark .content .summary-label {
                color: #a9b3c7 !important;
            }

            body.theme-dark .content .headline,
            body.theme-dark .content .value,
            body.theme-dark .content .label,
            body.theme-dark .content .panel-title,
            body.theme-dark .content .notifications-title,
            body.theme-dark .content .service-name,
            body.theme-dark .content .user-name,
            body.theme-dark .content .section-title,
            body.theme-dark .content .form-title,
            body.theme-dark .content .modal-title,
            body.theme-dark .content .modal-label,
            body.theme-dark .content .field label,
            body.theme-dark .content .control span,
            body.theme-dark .content .info-title,
            body.theme-dark .content .info-list,
            body.theme-dark .content .summary-value,
            body.theme-dark .content .order-code,
            body.theme-dark .content .history-code,
            body.theme-dark .content .order-detail-label,
            body.theme-dark .content .history-detail-label,
            body.theme-dark .content .data-row strong,
            body.theme-dark .content .customer-name,
            body.theme-dark .content .receipt-title,
            body.theme-dark .content .receipt-value,
            body.theme-dark .content .preview-name,
            body.theme-dark .content .flash-message,
            body.theme-dark .content .error-box {
                color: var(--text) !important;
            }

            body.theme-dark .content .service-estimate,
            body.theme-dark .content .upload-box strong,
            body.theme-dark .content .modal-btn.cancel,
            body.theme-dark .content .btn-outline,
            body.theme-dark .content .filter-btn.reset,
            body.theme-dark .content .back-link,
            body.theme-dark .content .order-detail,
            body.theme-dark .content .history-detail,
            body.theme-dark .content .order-detail strong {
                color: #d8dee9 !important;
            }

            body.theme-dark .content .modal-btn.cancel,
            body.theme-dark .content .btn-outline,
            body.theme-dark .content .filter-btn.reset {
                background: #1a202b !important;
            }

            body.theme-dark .content .filter-option.active,
            body.theme-dark .content .filter-option:hover {
                background: rgba(245, 124, 0, 0.16) !important;
                color: #ffd39b !important;
            }

            body.theme-dark .nav-item:hover,
            body.theme-dark .nav-item:focus-visible {
                background: rgba(245, 124, 0, 0.16);
                color: var(--text);
            }

            body.theme-dark .content :is(.edit-link, .edit-btn.cancel, .modal-btn.cancel, .filter-btn.reset, .btn-outline, .back-link, .tab, .filter-trigger):hover,
            body.theme-dark .content :is(.edit-link, .edit-btn.cancel, .modal-btn.cancel, .filter-btn.reset, .btn-outline, .back-link, .tab, .filter-trigger):focus-visible {
                background: rgba(245, 124, 0, 0.16) !important;
                border-color: var(--orange) !important;
                color: #ffd39b !important;
            }

            body.theme-dark .content .error-box {
                background: linear-gradient(180deg, #352026 0%, #2a1a20 100%) !important;
                border-color: rgba(214, 102, 92, 0.45) !important;
            }

            .content {
                padding: 0 36px;
            }

            @media (min-width: 981px) {
                .sidebar {
                    position: sticky;
                    top: 0;
                    align-self: start;
                    height: 100vh;
                    height: 100dvh;
                    overflow: hidden;
                }

                .sidebar-nav {
                    min-height: 0;
                    overflow-y: auto;
                }

                .sidebar-brand {
                    flex-shrink: 0;
                }
            }

            @media (max-width: 980px) {
                .admin-shell {
                    grid-template-columns: 1fr;
                }

                .sidebar {
                    border-right: 0;
                    border-bottom: 1px solid rgba(236, 231, 220, 0.9);
                }

                .sidebar-brand {
                    border-radius: 0 0 28px 28px;
                }

                .topbar,
                .content {
                    padding-left: 24px;
                    padding-right: 24px;
                }
            }

            @media (max-width: 700px) {
                .topbar {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .topbar-actions {
                    width: 100%;
                    justify-content: flex-start;
                    gap: 12px;
                }

                .admin-pill {
                    min-width: 0;
                    flex: 1;
                }

                .notification-panel {
                    right: 0;
                    width: min(320px, calc(100vw - 48px));
                }

                .admin-menu-panel {
                    right: 0;
                    width: min(260px, calc(100vw - 48px));
                }

                .dialog-actions {
                    flex-direction: column-reverse;
                }

                .dialog-btn {
                    width: 100%;
                }
            }
        </style>
        @stack('styles')
        <link rel="stylesheet" href="{{ asset('css/logout-dialog.css') }}">
        <link rel="stylesheet" href="{{ asset('css/notifications.css') }}">
        <style>
            .topbar .account-menu {
                width: 220px;
                max-width: 100%;
                flex-shrink: 0;
            }
            .account-menu .admin-pill {
                width: 100%;
                min-width: 0;
                height: auto;
                min-height: 72px;
                padding: 12px;
                gap: 12px;
                justify-content: flex-start;
                border: 1px solid #f1d4b6;
                border-radius: 16px;
                background: linear-gradient(120deg, #fff4e5, #fffaf4);
                box-shadow: 0 4px 12px #b96b1010;
                text-align: left;
            }
            .account-menu .admin-pill:hover,
            .account-menu .admin-pill[data-active='true'] {
                border-color: var(--orange);
                box-shadow: 0 6px 18px #e9822420;
            }
            .account-menu .admin-pill:focus-visible { outline: 2px solid var(--orange); outline-offset: 3px; }
            .account-menu .admin-pill span {
                position: static;
                transform: none;
                max-width: none;
                text-align: left;
            }
            .account-menu .account-avatar {
                display: grid;
                place-items: center;
                flex: 0 0 42px;
                height: 42px;
                border-radius: 13px;
                background: linear-gradient(140deg, #ffad4f, #e56a10);
                box-shadow: 0 4px 10px #e5752026;
                color: white;
                font-size: 1.1rem;
            }
            .account-menu .account-copy { flex: 1; min-width: 0; }
            .account-copy strong { display: block; overflow: hidden; text-overflow: ellipsis; font-size: .82rem; line-height: 1.5; }
            .account-copy small { display: flex; align-items: center; gap: 7px; margin-top: 4px; font-size: .65rem; font-weight: 500; color: #947356; }
            .account-copy i { width: 6px; height: 6px; border-radius: 50%; background: #35a579; }
            .account-menu .admin-pill svg { width: 18px; height: 18px; color: #b66c2b; }
            .account-menu .admin-menu-panel { top: calc(100% + 12px); bottom: auto; left: auto; right: 0; width: 260px; max-width: calc(100vw - 48px); padding: 8px; border-radius: 16px; }
            body.theme-dark .account-menu .admin-pill { background: linear-gradient(120deg, #35291f, #29241f); border-color: #67472c; }
            body.theme-dark .account-copy small { color: #cdb297; }
            @media (max-width: 980px) {
                .account-menu .admin-pill { min-height: 62px; }
            }
            .main > .topbar {
                position: relative;
                padding: 24px 32px;
                background: radial-gradient(ellipse at 20% 0%, #ffedd87a, transparent 65%), var(--topbar-bg);
                border-bottom: 1px solid var(--border-soft);
                border-radius: 0 0 24px 24px;
                box-shadow: 0 6px 24px #59442505;
                gap: 24px;
            }
            .main > .topbar::after { content: ''; position: absolute; bottom: -1px; left: 32px; width: 72px; height: 3px; border-radius: 3px; background: linear-gradient(90deg, #f57c00, #ffc985); }
            .topbar-heading { min-width: 0; }
            .topbar-breadcrumb { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; font-size: .61rem; color: var(--muted); }
            .topbar-breadcrumb a { color: #bd631b; font-weight: 700; letter-spacing: .14em; white-space: nowrap; }
            .topbar-breadcrumb > span:last-child { overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }
            .topbar .headline { font-size: clamp(1.35rem, 2vw, 1.8rem); letter-spacing: -.04em; line-height: 1.3; }
            .topbar .subheadline { font-size: .74rem; line-height: 1.6; margin-top: 7px; color: var(--muted); }
            .topbar .topbar-actions { gap: 12px; flex-shrink: 0; }
            .topbar-date { padding-right: 18px; margin-right: 4px; border-right: 1px solid var(--border-soft); }
            .topbar-date > span { display: block; font-size: .52rem; letter-spacing: .14em; color: var(--muted); margin-bottom: 6px; }
            .topbar-date time { display: block; font-size: .73rem; font-weight: 600; white-space: nowrap; }
            .topbar .icon-btn { width: 44px; height: 44px; border-radius: 13px; background: var(--panel); border: 1px solid var(--border-soft); box-shadow: 0 3px 8px #30201504; }
            .topbar .icon-btn svg { width: 22px; height: 22px; }
            .topbar .icon-btn:hover, .topbar .icon-btn[data-active='true'] { background: #fff0df; border-color: #e9b583; color: #c16820; }
            .topbar .icon-btn:focus-visible, .topbar-breadcrumb a:focus-visible { outline: 2px solid var(--orange); outline-offset: 3px; }
            body.theme-dark .main > .topbar { background: radial-gradient(ellipse at 20% 0%, #c77c1820, transparent 65%), var(--topbar-bg); }
            body.theme-dark .topbar-breadcrumb a { color: #efb47d; }
            body.theme-dark .topbar .icon-btn:hover, body.theme-dark .topbar .icon-btn[data-active='true'] { background: #392a1d; border-color: #815630; color: #ffc084; }
            @media (max-width: 1280px) { .topbar-date { display: none; } }
            @media (max-width: 700px) {
                .main > .topbar { padding: 20px; gap: 18px; align-items: stretch; }
                .topbar .topbar-actions { width: 100%; justify-content: flex-end; gap: 10px; }
                .topbar .account-menu { width: min(220px, calc(100% - 108px)); }
                .main > .topbar::after { left: 20px; }
            }
        </style>
        <link rel="stylesheet" href="{{ asset('css/account-menu.css') }}">
        <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    </head>
    <body>
        @php
            $activeMenu = trim($__env->yieldContent('active-menu'));
            $authUser = session('social_auth');
            $accountLabel = (($authUser['role'] ?? 'admin') === 'pegawai') ? 'Pegawai' : 'Admin';
            $newOrdersCount = \App\Models\Order::query()
                ->where('status', 'Baru')
                ->whereDate('created_at', now()->toDateString())
                ->count();
            $readyOrdersCount = \App\Models\Order::query()
                ->where('status', 'Siap Diambil')
                ->count();
            $processingOrdersCount = \App\Models\Order::query()
                ->where('status', 'Diproses')
                ->count();
            $rewardReadyCount = \App\Models\Customer::query()
                ->with('orders')
                ->get()
                ->sum(fn ($customer) => $customer->available_rewards);
            $adminNotifications = [];

            if ($newOrdersCount > 0) {
                $adminNotifications[] = [
                    'kind' => 'new',
                    'icon' => 'M4 5h16v15H4z M8 3v4M16 3v4M4 10h16M9 15h6M12 12v6',
                    'title' => $newOrdersCount . ' order baru hari ini',
                    'body' => 'Cek dan ubah status order baru ke diproses.',
                    'url' => route('orders.index', ['status' => 'Baru']),
                ];
            }

            if ($readyOrdersCount > 0) {
                $adminNotifications[] = [
                    'kind' => 'ready',
                    'icon' => 'M4 4h16v16H4z M8 12l3 3 5-6',
                    'title' => $readyOrdersCount . ' order siap diambil',
                    'body' => 'Hubungi pelanggan untuk proses pengambilan.',
                    'url' => route('orders.index', ['status' => 'Siap Diambil']),
                ];
            }

            if ($processingOrdersCount > 0) {
                $adminNotifications[] = [
                    'kind' => 'processing',
                    'icon' => 'M12 3a9 9 0 1 0 9 9 9 9 0 0 0-9-9 M12 7v5l3 2',
                    'title' => $processingOrdersCount . ' order sedang diproses',
                    'body' => 'Pantau pengerjaan agar selesai sesuai estimasi.',
                    'url' => route('orders.index', ['status' => 'Diproses']),
                ];
            }

            if ($rewardReadyCount > 0) {
                $adminNotifications[] = [
                    'kind' => 'reward',
                    'icon' => 'M3 8h18v4H3z M5 12v9h14v-9M12 8v13M12 8C4 8 5 1 9 3l3 5c8 0 7-7 3-5l-3 5',
                    'title' => $rewardReadyCount . ' reward member bisa diklaim',
                    'body' => 'Ada pelanggan dengan stempel penuh.',
                    'url' => route('customers.index'),
                ];
            }

            if (empty($adminNotifications)) {
                $adminNotifications[] = [
                    'title' => 'Belum ada notifikasi',
                    'body' => 'Aktivitas order dan member masih aman.',
                    'url' => null,
                ];
            }

            $notificationCount = $newOrdersCount + $readyOrdersCount + $processingOrdersCount + $rewardReadyCount;
        @endphp

        <div class="admin-shell">
            <aside class="sidebar">
                <div class="sidebar-brand">
                    <a href="/" class="brand" aria-label="Raab Shoes">
                        <img src="{{ asset('images/raabshoes-logo.svg') }}" alt="Raab Shoes" class="brand-logo">
                    </a>
                </div>

                <nav class="sidebar-nav" aria-label="Navigasi utama">
                    <div class="nav-list">
                        <div class="sidebar-group-label">RUANG KERJA</div>
                        <a href="{{ route('dashboard') }}" class="nav-item nav-tone-orange {{ $activeMenu === 'dashboard' ? 'active' : '' }}" @if($activeMenu === 'dashboard') aria-current="page" @endif>
                            <span class="nav-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="m3 10 9-7 9 7M5 9v11h5v-6h4v6h5V9"/></svg></span>
                            <span class="nav-copy"><strong>Dashboard</strong><small>Ringkasan aktivitas</small></span>
                        <span class="nav-arrow" aria-hidden="true">›</span>
                        </a>
                        <a href="{{ route('orders.index') }}" class="nav-item nav-tone-blue {{ $activeMenu === 'orders' ? 'active' : '' }}" @if($activeMenu === 'orders') aria-current="page" @endif>
                            <span class="nav-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="5" width="16" height="16" rx="3"/><path d="M8 3v4m8-4v4M4 11h16m-11 5h6"/></svg></span>
                            <span class="nav-copy"><strong>Order/Transaksi</strong><small>Kelola pesanan masuk</small></span>
                        <span class="nav-arrow" aria-hidden="true">›</span>
                        </a>
                        <a href="{{ route('customers.index') }}" class="nav-item nav-tone-purple {{ $activeMenu === 'customers' ? 'active' : '' }}" @if($activeMenu === 'customers') aria-current="page" @endif>
                            <span class="nav-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3"/><path d="M3 21v-2a6 6 0 0 1 12 0v2M16 5a3 3 0 0 1 0 6m2 4a5 5 0 0 1 3 4v2"/></svg></span>
                            <span class="nav-copy"><strong>Pelanggan</strong><small>Kenali pelangganmu</small></span>
                        <span class="nav-arrow" aria-hidden="true">›</span>
                        </a>
                        <a href="{{ route('services.index') }}" class="nav-item nav-tone-green {{ $activeMenu === 'services' ? 'active' : '' }}" @if($activeMenu === 'services') aria-current="page" @endif>
                            <span class="nav-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="2"/><rect x="14" y="3" width="7" height="7" rx="2"/><rect x="3" y="14" width="7" height="7" rx="2"/><path d="M14 17h7m-3.5-3.5v7"/></svg></span>
                            <span class="nav-copy"><strong>Layanan &amp; Harga</strong><small>Treatment & daftar harga</small></span>
                        <span class="nav-arrow" aria-hidden="true">›</span>
                        </a>
                        <div class="sidebar-group-label">INSIGHT TOKO</div>
                        <a href="{{ route('reports.index') }}" class="nav-item nav-tone-blue {{ $activeMenu === 'reports' ? 'active' : '' }}" @if($activeMenu === 'reports') aria-current="page" @endif>
                            <span class="nav-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M5 3h10l4 4v14H5zM14 3v5h5M9 17v-3m3 3v-6m3 6v-4"/></svg></span>
                            <span class="nav-copy"><strong>Laporan</strong><small>Pantau performa toko</small></span>
                        <span class="nav-arrow" aria-hidden="true">›</span>
                        </a>
                        <a href="{{ route('transaction-history.index') }}" class="nav-item nav-tone-purple {{ $activeMenu === 'transaction-history' ? 'active' : '' }}" @if($activeMenu === 'transaction-history') aria-current="page" @endif>
                            <span class="nav-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M3 10a9 9 0 1 1 1 7M3 4v6h6m3-3v5l3 2"/></svg></span>
                            <span class="nav-copy"><strong>Riwayat Transaksi</strong><small>Jejak setiap transaksi</small></span>
                        <span class="nav-arrow" aria-hidden="true">›</span>
                        </a>
                        <div class="sidebar-group-label">PREFERENSI</div>
                        <a href="{{ route(\App\Models\User::accountManager() ? 'settings.index' : 'settings.password') }}" class="nav-item nav-tone-neutral {{ $activeMenu === 'settings' ? 'active' : '' }}" @if($activeMenu === 'settings') aria-current="page" @endif>
                            <span class="nav-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7h16M4 17h16"/><circle cx="9" cy="7" r="3"/><circle cx="15" cy="17" r="3"/></svg></span>
                            <span class="nav-copy"><strong>Pengaturan</strong><small>Atur ruang kerjamu</small></span>
                        <span class="nav-arrow" aria-hidden="true">›</span>
                        </a>
                    </div>
                    <div class="sidebar-note"><span class="sidebar-note-spark" aria-hidden="true">✳</span><div><strong>Fresh shoes. Happy you.</strong><p>Detail kecil, langkah berarti.</p></div></div>
                    <a class="sidebar-home" href="{{ url('/') }}">Kunjungi beranda <span aria-hidden="true">↗</span></a>
                </nav>
            </aside>

            <main class="main">
                <header class="topbar">
                    <div class="topbar-heading">
                        <nav class="topbar-breadcrumb" aria-label="Lokasi halaman"><a href="{{ route('dashboard') }}">RAAB SHOES</a><span aria-hidden="true">/</span><span>@yield('page-title')</span></nav>
                        <h1 class="headline">@yield('page-title')</h1>
                        <p class="subheadline">@yield('page-subtitle')</p>
                    </div>

                    <div class="topbar-actions">
                        <div class="topbar-date"><span>HARI INI</span><time datetime="{{ now()->toDateString() }}">{{ now()->locale('id')->translatedFormat('d M Y') }}</time></div>
                        <button
                            type="button"
                            class="icon-btn"
                            id="theme-toggle"
                            aria-label="Ubah tema gelap atau terang"
                            title="Ubah tema"
                        >
                            <svg class="theme-icon moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M20.4 14.6A8.6 8.6 0 0 1 9.4 3.6 7.2 7.2 0 1 0 20.4 14.6Z"/>
                            </svg>
                            <svg class="theme-icon sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="12" cy="12" r="4"></circle>
                                <path d="M12 2.5v2.5"></path>
                                <path d="M12 19v2.5"></path>
                                <path d="m4.9 4.9 1.8 1.8"></path>
                                <path d="m17.3 17.3 1.8 1.8"></path>
                                <path d="M2.5 12H5"></path>
                                <path d="M19 12h2.5"></path>
                                <path d="m4.9 19.1 1.8-1.8"></path>
                                <path d="m17.3 6.7 1.8-1.8"></path>
                            </svg>
                        </button>
                        <div class="notification-menu">
                            <button
                                type="button"
                                class="icon-btn notification-btn"
                                id="notification-toggle"
                                aria-label="Buka notifikasi, {{ $notificationCount }} order dan reward"
                                aria-expanded="false"
                                aria-controls="notification-panel"
                                title="Notifikasi"
                            >
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M18 8.8a6 6 0 0 0-12 0c0 6.8-2.5 7.7-2.5 7.7h17S18 15.6 18 8.8Z"/>
                                    <path d="M9.8 19a2.3 2.3 0 0 0 4.4 0"/>
                                </svg>
                                <span class="notification-dot" aria-hidden="true" @if($notificationCount === 0) hidden @endif></span>
                            </button>

                            <div class="notification-panel" id="notification-panel" role="dialog" aria-label="Daftar notifikasi">
                                <div class="notification-heading"><div><span class="notification-eyebrow">PUSAT AKTIVITAS</span><h2 class="notification-title">Kabar dari toko</h2><p>Order dan reward dalam satu tempat.</p></div><span class="notification-total" title="Total order dan reward">{{ $notificationCount }}</span></div>
                                <div class="notification-list">
                                    @foreach($adminNotifications as $notification)
                                        @if($notification['url'])
                                            <a href="{{ $notification['url'] }}" class="notification-item notification-{{ $notification['kind'] }}">
                                                <span class="notification-symbol" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="{{ $notification['icon'] }}"/></svg></span>
                                                <div class="notification-copy"><strong>{{ $notification['title'] }}</strong><span>{{ $notification['body'] }}</span><small>{{ $notification['kind'] === 'reward' ? 'Lihat pelanggan' : 'Lihat order' }} <b aria-hidden="true">→</b></small></div>
                                            </a>
                                        @else
                                            <div class="notification-empty"><span aria-hidden="true">✓</span><strong>Semua sudah beres</strong><p>Belum ada aktivitas order atau reward untuk ditampilkan.</p></div>
                                        @endif
                                    @endforeach
                                </div>
                                <a class="notification-footer" href="{{ route('orders.index') }}">Buka semua order <span aria-hidden="true">↗</span></a>
                            </div>
                        </div>

                        <div class="admin-menu account-menu">
                            <button
                                type="button"
                                class="admin-pill"
                                id="admin-menu-toggle"
                                aria-label="Buka menu akun {{ $accountLabel }}"
                                aria-expanded="false"
                                aria-controls="admin-menu-panel"
                            >
                                <span class="account-avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr($authUser['name'] ?? $accountLabel, 0, 1)) }}</span>
                                <span class="account-copy"><strong>{{ $authUser['name'] ?? $accountLabel }}</strong><small>{{ $accountLabel }} <i aria-hidden="true"></i></small></span>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"/>
                                </svg>
                            </button>
                            <div class="admin-menu-panel" id="admin-menu-panel" role="region" aria-label="Menu akun">
                                <div class="account-cover" aria-hidden="true"><span>RAAB SHOES / MY SPACE</span><b>✳</b></div>
                                <div class="admin-menu-info">
                                    <div class="account-identity"><span class="account-large-avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr($authUser['name'] ?? $accountLabel, 0, 1)) }}</span><span class="account-status"><i aria-hidden="true"></i> Sesi aktif</span></div>
                                    <span class="admin-menu-name">{{ $authUser['name'] ?? $accountLabel }}</span>
                                    <span class="admin-menu-email">{{ $authUser['email'] ?? 'admin@raabshoes.com' }}</span>
                                    <span class="account-role">{{ $accountLabel }} <span aria-hidden="true">✦</span></span>
                                </div>
                                <div class="admin-menu-actions">
                                    <a href="{{ route('settings.password') }}" class="account-security">
                                        <span class="account-action-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="10" width="14" height="11" rx="3"/><path d="M8 10V7a4 4 0 0 1 8 0v3M12 14v3"/></svg></span>
                                        <span><strong>Keamanan akun</strong><small>Kelola password Anda</small></span><span class="account-action-arrow" aria-hidden="true">↗</span>
                                    </a>
                                    <button type="button" class="admin-menu-action" id="logout-trigger">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                            <path d="m16 17 5-5-5-5"/>
                                            <path d="M21 12H9"/>
                                        </svg>
                                        <span>Keluar dari akun</span><span class="account-action-arrow" aria-hidden="true">→</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <section class="content">
                    @yield('content')
                </section>
            </main>
        </div>

        <div class="dialog-backdrop" id="logout-dialog" aria-hidden="true">
            <div class="dialog-card" role="dialog" aria-modal="true" aria-labelledby="logout-dialog-title" aria-describedby="logout-dialog-description">
                <button type="button" class="logout-close" id="logout-close" aria-label="Tutup konfirmasi logout">×</button>
                <div class="logout-art" aria-hidden="true"><div class="logout-orbit"></div><div class="logout-icon"><svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M23 8H12a4 4 0 0 0-4 4v24a4 4 0 0 0 4 4h11"/><path d="M20 24h21M33 16l8 8-8 8"/><path d="M17 8v32" opacity=".35"/></svg></div><span class="logout-spark">✦</span></div>
                <span class="logout-eyebrow">SAMPAI JUMPA LAGI</span>
                <h2 class="dialog-title" id="logout-dialog-title">Selesai untuk sekarang?</h2>
                <p class="dialog-text" id="logout-dialog-description">Anda akan keluar dari akun Raab Shoes.<br>Login kembali kapan saja untuk melanjutkan pekerjaan.</p>
                <div class="dialog-actions">
                    <button type="button" class="dialog-btn cancel" id="logout-cancel">Tetap di Sini</button>
                    <form method="post" action="{{ route('logout') }}" id="logout-form">
                        @csrf
                        <button type="submit" class="dialog-btn confirm">Ya, Keluar <span aria-hidden="true">↗</span></button>
                    </form>
                </div>
            </div>
        </div>

        <script>
            (function () {
                const body = document.body;
                const themeToggle = document.getElementById('theme-toggle');
                const notificationToggle = document.getElementById('notification-toggle');
                const notificationPanel = document.getElementById('notification-panel');
                const adminMenuToggle = document.getElementById('admin-menu-toggle');
                const adminMenuPanel = document.getElementById('admin-menu-panel');
                const logoutTrigger = document.getElementById('logout-trigger');
                const logoutDialog = document.getElementById('logout-dialog');
                const logoutCancel = document.getElementById('logout-cancel');
                const storageKey = 'raab-admin-theme';

                if (themeToggle) {
                    const applyTheme = (theme) => {
                        const isDark = theme === 'dark';
                        body.classList.toggle('theme-dark', isDark);
                        themeToggle.setAttribute('aria-pressed', String(isDark));
                        themeToggle.dataset.active = String(isDark);
                    };

                    const savedTheme = localStorage.getItem(storageKey);
                    applyTheme(savedTheme === 'dark' ? 'dark' : 'light');

                    themeToggle.addEventListener('click', () => {
                        const nextTheme = body.classList.contains('theme-dark') ? 'light' : 'dark';
                        localStorage.setItem(storageKey, nextTheme);
                        applyTheme(nextTheme);
                    });
                }

                const setNotificationOpen = (open) => {
                    if (!notificationToggle || !notificationPanel) {
                        return;
                    }

                    notificationPanel.classList.toggle('is-open', open);
                    notificationToggle.setAttribute('aria-expanded', String(open));
                    notificationToggle.dataset.active = String(open);
                };

                if (notificationToggle && notificationPanel) {
                    notificationToggle.addEventListener('click', (event) => {
                        event.stopPropagation();
                        const willOpen = !notificationPanel.classList.contains('is-open');
                        if (adminMenuPanel) {
                            adminMenuPanel.classList.remove('is-open');
                        }
                        if (adminMenuToggle) {
                            adminMenuToggle.setAttribute('aria-expanded', 'false');
                            adminMenuToggle.dataset.active = 'false';
                        }
                        setNotificationOpen(willOpen);
                    });

                    notificationPanel.addEventListener('click', (event) => {
                        event.stopPropagation();
                    });
                }

                const setAdminMenuOpen = (open) => {
                    if (!adminMenuToggle || !adminMenuPanel) {
                        return;
                    }

                    adminMenuPanel.classList.toggle('is-open', open);
                    adminMenuToggle.setAttribute('aria-expanded', String(open));
                    adminMenuToggle.dataset.active = String(open);
                };

                if (adminMenuToggle && adminMenuPanel) {
                    adminMenuToggle.addEventListener('click', (event) => {
                        event.stopPropagation();
                        const willOpen = !adminMenuPanel.classList.contains('is-open');
                        setNotificationOpen(false);
                        setAdminMenuOpen(willOpen);
                    });

                    adminMenuPanel.addEventListener('click', (event) => {
                        event.stopPropagation();
                    });
                }

                const setLogoutDialogOpen = (open) => {
                    if (!logoutDialog) {
                        return;
                    }

                    const wasOpen = logoutDialog.classList.contains('is-open');
                    logoutDialog.classList.toggle('is-open', open);
                    logoutDialog.setAttribute('aria-hidden', String(!open));
                    body.style.overflow = open ? 'hidden' : '';
                    if (open) logoutCancel?.focus();
                    else if (wasOpen) adminMenuToggle?.focus();
                };

                if (logoutTrigger && logoutDialog) {
                    logoutTrigger.addEventListener('click', () => {
                        setAdminMenuOpen(false);
                        setLogoutDialogOpen(true);
                    });
                }

                document.getElementById('logout-close')?.addEventListener('click', () => setLogoutDialogOpen(false));

                if (logoutCancel && logoutDialog) {
                    logoutCancel.addEventListener('click', () => {
                        setLogoutDialogOpen(false);
                    });
                }

                if (logoutDialog) {
                    logoutDialog.addEventListener('click', (event) => {
                        if (event.target === logoutDialog) {
                            setLogoutDialogOpen(false);
                        }
                    });
                }

                document.addEventListener('click', () => {
                    setNotificationOpen(false);
                    setAdminMenuOpen(false);
                });

                document.addEventListener('keydown', (event) => {
                    if (event.key === 'Tab' && logoutDialog?.classList.contains('is-open')) {
                        const buttons = logoutDialog.querySelectorAll('button:not([disabled])');
                        const first = buttons[0];
                        const last = buttons[buttons.length - 1];
                        if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last.focus(); }
                        else if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first.focus(); }
                    }
                    if (event.key === 'Escape') {
                        setNotificationOpen(false);
                        setAdminMenuOpen(false);
                        setLogoutDialogOpen(false);
                    }
                });

            }());
        </script>
        @stack('scripts')
    </body>
</html>
