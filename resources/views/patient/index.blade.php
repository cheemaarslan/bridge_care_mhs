@extends('master.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('datatable/datatables.min.css') }}">


    <style>
        /* ── Design tokens ─────────────────────────────── */
        :root {
            --rpm-font: 'DM Sans', 'Segoe UI', system-ui, sans-serif;
            --rpm-mono: 'DM Mono', 'Fira Code', monospace;

            --rpm-bg: #f5f6f8;
            --rpm-surface: #ffffff;
            --rpm-border: #e2e5ea;
            --rpm-border-mid: #cdd2da;

            --rpm-text-primary: #1a2332;
            --rpm-text-secondary: #4a5568;
            --rpm-text-muted: #8492a6;

            --rpm-blue: #1a56db;
            --rpm-blue-light: #ebf0fd;
            --rpm-blue-mid: #c3d3f7;

            --rpm-normal-bg: #64c396;
            --rpm-normal-text: #FFFFFF;
            --rpm-normal-border: #6ee7b7;
            --rpm-s1-bg: #fffbeb;
            --rpm-s1-text: #000000;
            --rpm-s1-border: #fcd34d;
            --rpm-s2-bg: #fff4e6;
            --rpm-s2-text: #34241d;
            --rpm-s2-border: #fb923c;
            --rpm-crisis-bg: #fef2f2;
            --rpm-crisis-text: #FFFFFF;
            --rpm-crisis-border: #FF7D7D;

            --rpm-radius-sm: 4px;
            --rpm-radius-md: 8px;
            --rpm-radius-lg: 12px;
            --rpm-shadow-sm: 0 1px 3px rgba(0, 0, 0, .06), 0 1px 2px rgba(0, 0, 0, .04);
            --rpm-shadow-md: 0 4px 12px rgba(0, 0, 0, .08);
            --rpm-transition: .18s ease;
        }

        /* ── Google font import ────────────────────────── */
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap');

        /* ── Wrapper card ──────────────────────────────── */
        .rpm-card {
            background: var(--rpm-surface);
            border: 1px solid var(--rpm-border);
            border-radius: var(--rpm-radius-lg);
            box-shadow: var(--rpm-shadow-sm);
            overflow: hidden;
            font-family: var(--rpm-font);
        }

        /* ── Top bar ───────────────────────────────────── */
        .rpm-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            background: var(--rpm-surface);
            border-bottom: 1px solid var(--rpm-border);
            gap: 12px;
            flex-wrap: wrap;
        }

        .rpm-topbar-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .rpm-topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .rpm-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--rpm-text-primary);
            letter-spacing: -.2px;
            margin: 0;
        }

        .rpm-patient-count {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            font-weight: 500;
            color: var(--rpm-blue);
            background: var(--rpm-blue-light);
            border: 1px solid var(--rpm-blue-mid);
            border-radius: 20px;
            padding: 3px 10px;
        }

        /* ── Last updated + refresh ────────────────────── */
        .rpm-refresh-area {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .rpm-last-updated {
            font-size: 12px;
            color: var(--rpm-text-muted);
            font-family: var(--rpm-mono);
            letter-spacing: -.2px;
        }

        .rpm-last-updated span {
            color: var(--rpm-text-secondary);
            font-weight: 500;
        }

        .rpm-refresh-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            font-weight: 500;
            color: var(--rpm-text-secondary);
            background: var(--rpm-bg);
            border: 1px solid var(--rpm-border);
            border-radius: var(--rpm-radius-sm);
            padding: 5px 10px;
            cursor: pointer;
            transition: all var(--rpm-transition);
            font-family: var(--rpm-font);
        }

        .rpm-refresh-btn:hover {
            background: var(--rpm-blue-light);
            border-color: var(--rpm-blue-mid);
            color: var(--rpm-blue);
        }

        .rpm-refresh-btn svg {
            width: 13px;
            height: 13px;
            transition: transform .5s ease;
        }

        .rpm-refresh-btn.spinning svg {
            transform: rotate(360deg);
        }

        /* ── Filter bar ────────────────────────────────── */
        .rpm-filter-bar {
            display: flex;
            align-items: flex-end;
            gap: 10px;
            padding: 12px 20px;
            background: var(--rpm-bg);
            border-bottom: 1px solid var(--rpm-border);
            flex-wrap: wrap;
        }

        .rpm-filter-group {
            display: flex;
            flex-direction: column;
            gap: 4px;
            min-width: 130px;
        }

        .rpm-filter-group label {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .6px;
            color: var(--rpm-text-muted);
            white-space: nowrap;
        }

        .rpm-filter-group select {
            height: 32px;
            font-size: 12px;
            font-family: var(--rpm-font);
            font-weight: 500;
            color: var(--rpm-text-primary);
            background: var(--rpm-surface);
            border: 1px solid var(--rpm-border-mid);
            border-radius: var(--rpm-radius-sm);
            padding: 0 28px 0 9px;
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%238492a6' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 9px center;
            cursor: pointer;
            transition: border-color var(--rpm-transition), box-shadow var(--rpm-transition);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .rpm-filter-group select:hover {
            border-color: var(--rpm-blue-mid);
        }

        .rpm-filter-group select:focus {
            outline: none;
            border-color: var(--rpm-blue);
            box-shadow: 0 0 0 3px rgba(26, 86, 219, .1);
        }

        .rpm-filter-group select.active {
            border-color: var(--rpm-blue);
            background-color: var(--rpm-blue-light);
            color: var(--rpm-blue);
        }

        /* Care manager select — inline in filter bar */
        .rpm-cm-group {
            display: flex;
            flex-direction: column;
            gap: 4px;
            min-width: 160px;
        }

        .rpm-cm-group label {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .6px;
            color: var(--rpm-text-muted);
        }

        #select_care_manager_rpm select {
            height: 32px;
            font-size: 12px;
            font-family: var(--rpm-font);
            font-weight: 500;
            color: var(--rpm-text-primary);
            background: var(--rpm-surface);
            border: 1px solid var(--rpm-border-mid);
            border-radius: var(--rpm-radius-sm);
            padding: 0 28px 0 9px;
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%238492a6' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 9px center;
            cursor: pointer;
            transition: border-color var(--rpm-transition), box-shadow var(--rpm-transition);
            width: 100%;
        }

        #select_care_manager_rpm select:hover {
            border-color: var(--rpm-blue-mid);
        }

        #select_care_manager_rpm select:focus {
            outline: none;
            border-color: var(--rpm-blue);
            box-shadow: 0 0 0 3px rgba(26, 86, 219, .1);
        }

        /* Active filter tags */
        .rpm-active-tags {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 20px;
            background: var(--rpm-surface);
            border-bottom: 1px solid var(--rpm-border);
            flex-wrap: wrap;
            min-height: 0;
            transition: all var(--rpm-transition);
        }

        .rpm-active-tags:empty {
            display: none;
        }

        .rpm-active-tags-label {
            font-size: 11px;
            font-weight: 600;
            color: var(--rpm-text-muted);
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-right: 2px;
        }

        .rpm-tag {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 500;
            color: var(--rpm-blue);
            background: var(--rpm-blue-light);
            border: 1px solid var(--rpm-blue-mid);
            border-radius: 20px;
            padding: 2px 8px 2px 10px;
            animation: tagIn .15s ease;
        }

        @keyframes tagIn {
            from {
                opacity: 0;
                transform: scale(.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .rpm-tag-x {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: rgba(26, 86, 219, .15);
            cursor: pointer;
            font-size: 10px;
            line-height: 1;
            color: var(--rpm-blue);
            margin-left: 2px;
            transition: background var(--rpm-transition);
        }

        .rpm-tag-x:hover {
            background: var(--rpm-blue);
            color: #fff;
        }

        .rpm-clear-all {
            font-size: 11px;
            font-weight: 500;
            color: var(--rpm-text-muted);
            cursor: pointer;
            padding: 2px 6px;
            border-radius: 4px;
            transition: all var(--rpm-transition);
            margin-left: 4px;
            text-decoration: underline;
            text-underline-offset: 2px;
            text-decoration-style: dotted;
        }

        .rpm-clear-all:hover {
            color: #dc2626;
        }

        /* ── Table wrapper ─────────────────────────────── */
        .rpm-table-wrap {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* ── DataTable overrides — clinical style ──────── */
        #rpm_patient_table_wrapper .dataTables_length,
        #rpm_patient_table_wrapper .dataTables_filter,
        #rpm_patient_table_wrapper .dataTables_info,
        #rpm_patient_table_wrapper .dataTables_paginate {
            font-family: var(--rpm-font);
            font-size: 12px;
            color: var(--rpm-text-secondary);
            padding: 10px 20px;
        }

        #rpm_patient_table_wrapper .dataTables_length select,
        #rpm_patient_table_wrapper .dataTables_filter input {
            height: 30px;
            font-size: 12px;
            font-family: var(--rpm-font);
            border: 1px solid var(--rpm-border-mid);
            border-radius: var(--rpm-radius-sm);
            padding: 0 8px;
            color: var(--rpm-text-primary);
            background: var(--rpm-surface);
        }

        #rpm_patient_table_wrapper .dataTables_filter input:focus {
            outline: none;
            border-color: var(--rpm-blue);
            box-shadow: 0 0 0 3px rgba(26, 86, 219, .1);
        }

        #rpm_patient_table_wrapper .dt-buttons {
            display: flex;
            gap: 6px;
        }

        #rpm_patient_table_wrapper .dt-button {
            font-family: var(--rpm-font) !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            color: var(--rpm-text-secondary) !important;
            background: var(--rpm-surface) !important;
            border: 1px solid var(--rpm-border-mid) !important;
            border-radius: var(--rpm-radius-sm) !important;
            padding: 5px 12px !important;
            box-shadow: none !important;
            transition: all var(--rpm-transition) !important;
        }

        #rpm_patient_table_wrapper .dt-button:hover {
            background: var(--rpm-bg) !important;
            border-color: var(--rpm-blue-mid) !important;
            color: var(--rpm-blue) !important;
        }

        /* ── Table itself ──────────────────────────────── */
        table#rpm_patient_table {
            font-family: var(--rpm-font);
            font-size: 12.5px;
            color: var(--rpm-text-primary);
            border-collapse: separate !important;
            border-spacing: 0;
            width: 100% !important;
        }

        table#rpm_patient_table thead th {
            background: #f8f9fb;
            color: var(--rpm-text-muted);
            font-size: 10.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .55px;
            padding: 10px 12px;
            border-bottom: 1.5px solid var(--rpm-border);
            border-top: none;
            white-space: nowrap;
            cursor: pointer;
            user-select: none;
            transition: background var(--rpm-transition), color var(--rpm-transition);
            position: relative;
        }

        table#rpm_patient_table thead th:hover {
            background: var(--rpm-blue-light);
            color: var(--rpm-blue);
        }

        table#rpm_patient_table thead th.sorting_asc,
        table#rpm_patient_table thead th.sorting_desc {
            background: var(--rpm-blue-light);
            color: var(--rpm-blue);
        }

        table#rpm_patient_table thead th::after,
        table#rpm_patient_table thead th::before {
            display: none !important;
        }

        table#rpm_patient_table thead th.sorting_asc .rpm-sort-icon::after {
            content: ' ↑';
        }

        table#rpm_patient_table thead th.sorting_desc .rpm-sort-icon::after {
            content: ' ↓';
        }

        table#rpm_patient_table tbody tr {
            transition: background var(--rpm-transition);
            border-bottom: 1px solid var(--rpm-border);
        }

        table#rpm_patient_table tbody tr:last-child {
            border-bottom: none;
        }

        table#rpm_patient_table tbody tr:hover {
            background: #fafbfd !important;
        }

        table#rpm_patient_table tbody tr.rpm-crisis-row {
            background: #fff8f8 !important;
        }

        table#rpm_patient_table tbody tr.rpm-crisis-row:hover {
            background: #fef2f2 !important;
        }

        table#rpm_patient_table tbody td {
            padding: 10px 12px;
            vertical-align: middle;
            border-top: none;
            color: var(--rpm-text-primary);
        }

        /* row number */
        table#rpm_patient_table tbody td:first-child {
            font-size: 11px;
            color: var(--rpm-text-muted);
            font-family: var(--rpm-mono);
            width: 36px;
            text-align: center;
        }

        /* patient name link */
        table#rpm_patient_table tbody td a {
            color: var(--rpm-blue);
            font-weight: 500;
            text-decoration: none;
            transition: color var(--rpm-transition);
        }

        table#rpm_patient_table tbody td a:hover {
            color: #1240a0;
            text-decoration: underline;
        }

        /* numeric / mono cells */
        table#rpm_patient_table tbody td.rpm-mono {
            font-family: var(--rpm-mono);
            font-size: 12px;
            color: var(--rpm-text-secondary);
        }

        /* ── Status & category badges ──────────────────── */
        .rpm-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .2px;
            padding: 3px 9px;
            border-radius: 20px;
            border: 1px solid;
            white-space: nowrap;
            line-height: 1;
        }

        .rpm-badge-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .rpm-badge.Normal,
        .rpm-badge.normal {
            background: var(--rpm-normal-bg);
            color: var(--rpm-normal-text);
            border-color: var(--rpm-normal-border);
        }

        .rpm-badge.Normal .rpm-badge-dot,
        .rpm-badge.normal .rpm-badge-dot {
            background: var(--rpm-normal-text);
        }

        .rpm-badge.Stage-1 {
            background: var(--rpm-s1-bg);
            color: var(--rpm-s1-text);
            border-color: var(--rpm-s1-border);
        }

        .rpm-badge.Stage-1 .rpm-badge-dot {
            background: var(--rpm-s1-text);
        }

        .rpm-badge.Stage-2 {
            background: var(--rpm-s2-bg);
            color: var(--rpm-s2-text);
            border-color: var(--rpm-s2-border);
        }

        .rpm-badge.Stage-2 .rpm-badge-dot {
            background: var(--rpm-s2-text);
        }

        .rpm-badge.Crisis {
            background: #fb1031;
            color: var(--rpm-crisis-text);
            border-color: var(--rpm-crisis-border);
        }

        .rpm-badge.Crisis .rpm-badge-dot {
            background: var(--rpm-crisis-text);
        }

        .rpm-badge.Crisis {
            animation: crisisPulse 1s ease-in-out infinite;
        }

        @keyframes crisisPulse {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(220, 38, 38, .15);
            }

            50% {
                box-shadow: 0 0 0 4px rgba(220, 38, 38, .08);
            }
        }

        /* no-data pill */
        .rpm-no-data {
            font-size: 11px;
            color: var(--rpm-text-muted);
            background: var(--rpm-bg);
            border: 1px dashed var(--rpm-border-mid);
            border-radius: 4px;
            padding: 2px 7px;
            font-family: var(--rpm-mono);
        }

        /* call badge */
        .rpm-call-yes {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 600;
            color: #065f46;
            background: #ecfdf5;
            border: 1px solid #6ee7b7;
            border-radius: 4px;
            padding: 2px 8px;
        }

        .rpm-call-no {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            color: var(--rpm-text-muted);
            background: var(--rpm-bg);
            border: 1px solid var(--rpm-border);
            border-radius: 4px;
            padding: 2px 8px;
        }

        /* bp value */
        .rpm-bp {
            font-family: var(--rpm-mono);
            font-size: 12px;
            font-weight: 500;
        }

        .rpm-bp.Normal {
            color: var(--rpm-normal-text);
        }

        .rpm-bp.Stage-1 {
            color: var(--rpm-s1-text);
        }

        .rpm-bp.Stage-2 {
            color: var(--rpm-s2-text);
        }

        .rpm-bp.Crisis {
            color: var(--rpm-crisis-text);
            font-weight: 700;
        }

        /* time / minutes cells */
        .rpm-time {
            font-family: var(--rpm-mono);
            font-size: 12px;
            color: var(--rpm-text-secondary);
        }

        /* action dropdown */
        .rpm-action-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-family: var(--rpm-font);
            font-size: 11.5px;
            font-weight: 500;
            color: var(--rpm-text-secondary);
            background: var(--rpm-surface);
            border: 1px solid var(--rpm-border-mid);
            border-radius: var(--rpm-radius-sm);
            padding: 5px 9px;
            cursor: pointer;
            transition: all var(--rpm-transition);
        }

        .rpm-action-btn:hover {
            background: var(--rpm-bg);
            border-color: var(--rpm-blue-mid);
            color: var(--rpm-blue);
        }

        .rpm-action-btn svg {
            width: 12px;
            height: 12px;
        }

        .rpm-dropdown-menu {
            font-family: var(--rpm-font);
            font-size: 12.5px;
            border: 1px solid var(--rpm-border);
            border-radius: var(--rpm-radius-md);
            box-shadow: var(--rpm-shadow-md);
            padding: 4px;
            min-width: 120px;
        }

        .rpm-dropdown-menu .dropdown-item {
            border-radius: var(--rpm-radius-sm);
            padding: 6px 10px;
            font-size: 12.5px;
            color: var(--rpm-text-primary);
            display: flex;
            align-items: center;
            gap: 6px;
            transition: background var(--rpm-transition);
        }

        .rpm-dropdown-menu .dropdown-item:hover {
            background: var(--rpm-blue-light);
            color: var(--rpm-blue);
        }

        .rpm-dropdown-menu .dropdown-item i {
            font-size: 11px;
            width: 14px;
        }

        /* ── Pagination ────────────────────────────────── */
        #rpm_patient_table_wrapper .paginate_button {
            font-family: var(--rpm-font) !important;
            font-size: 12px !important;
            border-radius: var(--rpm-radius-sm) !important;
            border: 1px solid var(--rpm-border) !important;
            padding: 4px 10px !important;
            color: var(--rpm-text-secondary) !important;
            background: var(--rpm-surface) !important;
            transition: all var(--rpm-transition) !important;
            margin: 0 2px !important;
        }

        #rpm_patient_table_wrapper .paginate_button:hover:not(.disabled) {
            background: var(--rpm-blue-light) !important;
            border-color: var(--rpm-blue-mid) !important;
            color: var(--rpm-blue) !important;
        }

        #rpm_patient_table_wrapper .paginate_button.current {
            background: var(--rpm-blue) !important;
            border-color: var(--rpm-blue) !important;
            color: #fff !important;
            font-weight: 600 !important;
        }

        /* ── Spinner overlay ───────────────────────────── */
        .rpm-spinner-overlay {
            display: none;
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, .65);
            backdrop-filter: blur(1px);
            z-index: 10;
            align-items: center;
            justify-content: center;
            border-radius: 0 0 var(--rpm-radius-lg) var(--rpm-radius-lg);
        }

        .rpm-spinner-overlay.active {
            display: flex;
        }

        .rpm-spinner {
            width: 28px;
            height: 28px;
            border: 2.5px solid var(--rpm-border);
            border-top-color: var(--rpm-blue);
            border-radius: 50%;
            animation: spin .7s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* striped rows (override Bootstrap) */
        table#rpm_patient_table tbody tr:nth-child(odd) {
            background: #fafbfc;
        }

        table#rpm_patient_table tbody tr:nth-child(even) {
            background: var(--rpm-surface);
        }



        /* ════════════════════════════════════════════════════════
                                       RPM DASHBOARD STATS  — add to your existing stylesheet
                                       (existing .rpm-summary-panel CSS stays unchanged below)
                                       ════════════════════════════════════════════════════════ */

        /* ── Outer wrapper ── */

        .rpm-kpi-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1px;
            background: var(--rpm-border);
        }

        .rpm-kpi-card {
            background: white;
            padding: 20px 24px;
            position: relative;
            transition: transform 0.2s ease;
        }

        .rpm-kpi-card:hover {
            transform: translateY(-2px);
        }

        .rpm-kpi-label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--rpm-text-muted);
            margin-bottom: 6px;
        }

        .rpm-kpi-value {
            font-size: 32px;
            font-weight: 700;
            line-height: 1;
            color: var(--rpm-text-primary);
            margin-bottom: 4px;
        }

        .rpm-kpi-crisis .rpm-kpi-value {
            color: #ef4444;
        }

        .rpm-kpi-sub {
            font-size: 12.5px;
            color: var(--rpm-text-muted);
        }

        .rpm-kpi-bar {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--c), var(--c));
            border-radius: 0 4px 0 0;
        }

        /* Charts Section */
        .rpm-charts-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1px;
            background: var(--rpm-border);
            padding: 1px;
        }

        .rpm-chart-card {
            background: white;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .rpm-chart-title {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            color: var(--rpm-text-muted);
            margin-bottom: 16px;
        }

        .rpm-donut-wrap {
            position: relative;
            width: 138px;
            height: 138px;
            margin: 0 auto 18px;
        }

        .rpm-donut-center {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .rpm-donut-num {
            font-size: 26px;
            font-weight: 700;
            color: var(--rpm-text-primary);
        }

        .rpm-donut-lbl {
            font-size: 10px;
            color: var(--rpm-text-muted);
            margin-top: 2px;
        }

        .rpm-chart-legend {
            display: flex;
            flex-direction: column;
            gap: 7px;
            font-size: 12.5px;
        }

        .rpm-leg-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .rpm-leg-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .rpm-leg-item strong {
            margin-left: auto;
            font-weight: 600;
            min-width: 24px;
            text-align: right;
        }

        .rpm-leg-item em {
            font-style: normal;
            color: var(--rpm-text-muted);
            font-size: 11px;
            min-width: 38px;
            text-align: right;
        }

        /* Bar Chart Card */
        .rpm-chart-bar-card .rpm-bar-stats {
            margin-top: 12px;
            font-size: 12.5px;
        }

        .rpm-bar-stat {
            display: flex;
            justify-content: space-between;
            padding: 4px 0;
        }

        .rpm-bar-stat-lbl {
            color: var(--rpm-text-muted);
        }

        /* Summary Chips - Matches Screenshot Style */
        .rpm-summary-panel {
            padding: 20px 24px;
            background: white;
            border-bottom: 1px solid var(--rpm-border);
        }

        .rpm-summary-group {
            margin-bottom: 18px;
        }

        .rpm-summary-label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--rpm-text-muted);
            margin-bottom: 10px;
        }

        .rpm-summary-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .rpm-sum-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 9999px;
            font-size: 12.5px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .rpm-sum-chip:hover {
            transform: translateY(-1px);
        }

        .rpm-sum-chip.Normal {
            background: #ecfdf5;
            color: #166534;
            border-color: #86efac;
        }

        .rpm-sum-chip.Stage-1 {
            background: #fefce8;
            color: #854d0e;
            border-color: #fde047;
        }

        .rpm-sum-chip.Stage-2 {
            background: #fff7ed;
            color: #9a3412;
            border-color: #fb923c;
        }

        .rpm-sum-chip.Crisis {
            background: #fef2f2;
            color: #991b1b;
            border-color: #fda4af;
        }

        .rpm-sum-chip.no-data {
            background: #f1f5f9;
            color: #475569;
        }

        .rpm-sum-chip.total {
            background: #f8fafc;
            color: #1e2937;
            font-weight: 600;
        }

        .rpm-sum-chip strong {
            font-weight: 700;
            margin-left: 4px;
        }

        /* Filter Bar */
        .rpm-filter-bar {
            padding: 18px 24px;
            background: #f8fafc;
            border-bottom: 1px solid var(--rpm-border);
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            align-items: flex-end;
        }

        .rpm-filter-group {
            flex: 1;
            min-width: 140px;
        }

        .rpm-filter-group label {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--rpm-text-muted);
            margin-bottom: 5px;
            display: block;
        }

        /* Responsive */
        @media (max-width: 1024px) {

            .rpm-kpi-row,
            .rpm-charts-row {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {

            .rpm-kpi-row,
            .rpm-charts-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection
@section('breadcrum')
    <ol class="breadcrumb p-4">
        <li class="breadcrumb-item font-weight-bold">
            <a href="{{ route('home') }}" class="inactive">{{ env('APP_NAME') }} </a>
        </li>

        <?php $link = ' '; ?>
        @for ($i = 1; $i <= count(Request::segments()); $i++)
            @if (($i < count(Request::segments())) & ($i > 0))
                <?php $link .= ' /' . Request::segment($i); ?>
                @if ($i == 1)
                    <li class="breadcrumb-item font-weight-bold">
                        <a href="<?= $link ?>" class="inactive">
                            {{ ucwords(str_replace('-', ' ', Request::segment($i))) }}</a>
                    </li>
                @else
                    <li class="breadcrumb-item font-weight-bold">
                        <a href="<?= $link ?>"
                            class="inactive">{{ ucwords(str_replace('-', ' ', Request::segment($i))) }}</a>
                    </li>
                @endif
            @else
                <li class="breadcrumb-item font-weight-bold">
                    <a class="active"> {{ ucwords(str_replace('-', ' ', Request::segment($i))) }}</a>
                </li>
            @endif
        @endfor
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6 col-12">
            <div class="card-group">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="card-title mb-2">Practice Name:</h3>
                        <h3><a
                                href="{{ route('practice.show', auth()->user()->practice) }}">{{ auth()->user()->practice->practice_name }}</a>
                        </h3>
                        @can('create_practice')
                            <a href="{{ route('patient.create') }}" class="btn btn-success mt-4"><i class="fas fa-plus"></i></a>
                        @endcan
                        @can('crud_practice')
                            <a type="button" href="{{ route('practice.index') }}" class="btn btn-success mt-4">View all
                                Practices</a>
                        @endcan
                    </div>
                </div>
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="card-title mb-2">Total Patients:</h3>
                        <h3>{{ $total_patient }}</h3>
                        @can('create_patient')
                            <a href="{{ route('patient.create') }}" class="btn btn-success mt-4"><i
                                    class="fas fa-plus"></i></a>
                        @endcan
                        @can('view_all_patient')
                            <a href="{{ route('patient.index') }}" class="btn btn-success mt-4">View All Patient</a>
                        @endcan

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-12">
            <div class="card-group">
                <!-- Column -->
                {{-- <div class="card shadow bg-success">
                    <div class="card-body text-center">
                        <h3 class="card-title text-white mb-2">CCM Patient:</h3>
                        <h3 class="text-white">{{ $ccm_patient_count }}</h3>
                        <div class="row text-center text-white">
                            <div class="col-6">
                                <span class="font-14">Simple</span>
                                <p class="font-14">{{ $simple }}</p>
                            </div>
                            <div class="col-6">
                                <span class="font-14">Complex</span>
                                <p class="font-14">{{ $complex }}</p>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <!-- Column -->
                <!-- Column -->
              <div class="card shadow bg-success" style="height: 165px;">
                    <div class="card-body text-center text-white" style="height: 165px;">
                        <h3 class="text-white">RPM Patient</h3>
                        <h5 class="text-white display-7">{{ $rpm_patient_count }}</h5>
                    </div>
                </div>
                <!-- Column -->
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Column -->
        <div class="col-lg-6 col-md-6">
            <div class="card">
                <div class="card-header bg-success text-center shadow">
                    <h4 class="text-white">Care Plan</h4>
                </div>
                <div class="card-body weather-small">
                    <div class="row">
                        <div class="col-3 text-center">
                            <h1 class="font-weight-light mb-0"><a
                                    href="{{ route('care-plan.filter', ['filter' => 'all']) }}">{{ $all_care_plan }}</a>
                            </h1>
                            <small>Total</small>
                        </div>
                        <div class="col-3 text-center">
                            <h1 class="font-weight-light mb-0"><a
                                    href="{{ route('care-plan.filter', ['filter' => 'remaining']) }}">{{ $remaining_care_plan }}</a>
                            </h1>
                            <small>Remaining</small>
                        </div>
                        <div class="col-3 text-center">
                            <h1 class="font-weight-light mb-0"><a
                                    href="{{ route('care-plan.filter', ['filter' => 'less-than']) }}">{{ $less_than_care_plan }}</a>
                            </h1>
                            <strong><i class="fa fa-angle-left" aria-hidden="true"></i>
                            </strong><small> 10 min</small>
                        </div>
                        <div class="col-3 text-center">
                            <h1 class="font-weight-light mb-0"><a
                                    href="{{ route('care-plan.filter', ['filter' => 'greater-than']) }}">{{ $greater_than_care_plan }}</a>
                            </h1>
                            <strong><i class="fa fa-angle-right" aria-hidden="true"></i>
                            </strong><small> 10 min</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Column -->
        <div class="col-lg-6 col-md-6">
            <div class="card">
                <div class="card-header bg-success text-center shadow">
                    <h4 class="text-white">Monthly Review</h4>
                </div>
                <div class="card-body weather-small">
                    <div class="row">
                        <div class="col-3 text-center">
                            <h1 class="font-weight-light mb-0"><a
                                    href="{{ route('monthly-review.filter', ['filter' => 'all']) }}">{{ $all_monthly_review }}</a>
                            </h1>
                            <small>Total</small>
                        </div>
                        <div class="col-3 text-center">
                            <h1 class="font-weight-light mb-0"><a
                                    href="{{ route('monthly-review.filter', ['filter' => 'remaining']) }}">{{ $remaining_monthly_review }}</a>
                            </h1>
                            <small>Remaining</small>
                        </div>
                        <div class="col-3 text-center">
                            <h1 class="font-weight-light mb-0"><a
                                    href="{{ route('monthly-review.filter', ['filter' => 'less-than']) }}">{{ $less_than_monthly_review }}</a>
                            </h1>
                            <strong><i class="fa fa-angle-left" aria-hidden="true"></i>
                            </strong><small> 10 min</small>
                        </div>
                        <div class="col-3 text-center">
                            <h1 class="font-weight-light mb-0"><a
                                    href="{{ route('monthly-review.filter', ['filter' => 'greater-than']) }}">{{ $greater_than_monthly_review }}</a>
                            </h1>
                            <strong><i class="fa fa-angle-right" aria-hidden="true"></i>
                            </strong><small> 10 min</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs mb-3">
                        {{-- <li class="nav-item">
                            <a href="#ccm" id="ccm_link" data-toggle="tab" aria-expanded="true"
                                class="nav-link {{ $ccm ? 'active' : '' }}">
                                <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                                <span class="d-none d-lg-block">CCM Patient</span>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a href="#rpm" id="rpm_link" data-toggle="tab" aria-expanded="false"
                                class="nav-link {{ $rpm ? 'active' : '' }}">
                                <i class="mdi mdi-account-circle d-lg-none d-block mr-1"></i>
                                <span class="d-none d-lg-block">RPM Patient</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#unenrolled" id="unenrolled_link" data-toggle="tab" aria-expanded="false"
                                class="nav-link {{ $unenrolled ? 'active' : '' }}">
                                <i class="mdi mdi-account-circle d-lg-none d-block mr-1"></i>
                                <span class="d-none d-lg-block">Unenrolled Patient</span>
                            </a>
                        </li>

                    </ul>

                    <div class="tab-content">
                        {{-- <div class="tab-pane {{ $ccm ? 'show active' : '' }}" id="ccm">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="input-group">
                                        <select class="form-control" name="select_care_manager_ccm"
                                            id="select_care_manager_ccm" style="width: 200px;">
                                            <option value="None"> --select care manager--</option>
                                        </select>
                                        <select class="form-control" name="select_last_ccm_performed"
                                            id="select_last_ccm_performed" style="width: 200px;">
                                            <option value="None"
                                                {{ $select_last_ccm_performed == 'None' ? 'selected' : '' }}> --Last CCM
                                                Performed--</option>
                                            <option value="Today"
                                                {{ $select_last_ccm_performed == 'Today' ? 'selected' : '' }}>Today
                                            </option>
                                            <option value="Yesterday"
                                                {{ $select_last_ccm_performed == 'Yesterday' ? 'selected' : '' }}>Yesterday
                                            </option>
                                            <option value="This-Month"
                                                {{ $select_last_ccm_performed == 'This-Month' ? 'selected' : '' }}>This
                                                Month</option>
                                            <option value="Prev-Month"
                                                {{ $select_last_ccm_performed == 'Prev-Month' ? 'selected' : '' }}>Prev
                                                Month</option>
                                        </select>
                                        <select class="form-control" name="select_covid_status_ccm"
                                            id="select_covid_status_ccm" style="width: 200px;">
                                            <option value="None"
                                                {{ $select_covid_status_ccm == 'None' ? 'selected' : '' }}> --covid
                                                status--</option>
                                            <option value="Positive"
                                                {{ $select_covid_status_ccm == 'Positive' ? 'selected' : '' }}>Positive
                                            </option>
                                            <option value="Negative"
                                                {{ $select_covid_status_ccm == 'Negative' ? 'selected' : '' }}>Negative
                                            </option>
                                            <option value="Unknown"
                                                {{ $select_covid_status_ccm == 'Unknown' ? 'selected' : '' }}>Unknown
                                            </option>
                                        </select>
                                        <select class="form-control" name="select_gender_ccm" id="select_gender_ccm"
                                            style="width: 200px;">
                                            <option value="None" {{ $select_gender_ccm == 'None' ? 'selected' : '' }}>
                                                --select gender--</option>
                                            <option value="Male" {{ $select_gender_ccm == 'Male' ? 'selected' : '' }}>
                                                Male</option>
                                            <option value="Female" {{ $select_gender_ccm == 'Female' ? 'selected' : '' }}>
                                                Female</option>
                                        </select>
                                        <form action="{{ route('reset.ccm.sort') }}" method="post">
                                            @csrf
                                            <button class="btn btn-danger" type="submit">
                                                <i class="fa fa-filter mr-1" aria-hidden="true"></i>Reset
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="ccm_patient_table" class="table table-striped table-bordered w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Patient Name</th>
                                            <th>Covid Status</th>
                                            <th>Gender</th>
                                            <th>Contact No</th>
                                            <th>Enrol Date</th>
                                            <th>Care Manager</th>
                                            <th>Care Plan Created</th>
                                            <th>Last CCM Performed</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sr_no = 1;
                                        @endphp
                                        @foreach ($ccm_patients as $item)
                                            <tr>
                                                <td>{{ $sr_no++ }}</td>
                                                @php
                                                    $current = Carbon\Carbon::now()->timestamp;
                                                    $ccm_enrol_timestamp = Carbon\Carbon::parse($item->ccm_enrol_date)
                                                        ->timestamp;
                                                    $care_plan_timestamp = '-';
                                                    if ($item->care_plan) {
                                                        $care_plan_timestamp = Carbon\Carbon::parse(
                                                            $item->care_plan->completed_at,
                                                        )->timestamp;
                                                    }
                                                    $last_ccm_timestamp = Carbon\Carbon::parse(
                                                        $item->last_ccm_performed,
                                                    )->timestamp;
                                                @endphp
                                                <td>
                                                    <a
                                                        href="{{ route('patient.show', ['patient' => $item, 'type' => 'ccm']) }}"><strong>{{ $item->first_name }}
                                                            {{ $item->last_name }}</strong></a>
                                                </td>
                                                <td>{{ $item->covid_status }}</td>
                                                <td>{{ $item->gender }}</td>
                                                <td>{{ $item->contact_no }}</td>
                                                <td data-sort="{{ $ccm_enrol_timestamp }}">
                                                    {{ $item->formatted_ccm_enrol_date }}</td>
                                                <td>{{ $item->care_manager ? $item->care_manager->user_name : '-' }}</td>
                                                <td data-sort="{{ $care_plan_timestamp }}">
                                                    {{ $item->care_plan ? $item->care_plan->formatted_completed_at : '-' }}
                                                </td>
                                                <td data-sort="{{ $last_ccm_timestamp }}">
                                                    {{ $item->formatted_last_ccm_performed }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-success dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="ti-settings"></i>
                                                        </button>
                                                        <div class="dropdown-menu slideInUp">
                                                            <a class="dropdown-item"
                                                                href="{{ route('patient.show', ['patient' => $item, 'type' => 'ccm']) }}"><i
                                                                    class="ti-eye"></i> Open</a>
                                                            <a class="dropdown-item"
                                                                href="{{ route('patient.edit', $item) }}"><i
                                                                    class="ti-pencil-alt"></i> Edit</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>

                        </div> --}}
                        <div class="tab-pane {{ $rpm ? 'show active' : '' }}" id="rpm">

                            <div class="row mb-3">
                                <div class="col-5">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Rpm Record Date"
                                            value="{{ $from }}" readonly>
                                        <button type="button" class="btn btn-danger">To</button>
                                        <input type="text" class="form-control" placeholder="Rpm Record Date"
                                            value="{{ $to }}" readonly>
                                        @can('reset_rpm_record')
                                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                                data-target="#rpm_reset_modal">Reset</button>
                                        @endcan
                                    </div>
                                </div>
                                <div class="col-2">
                                    <button type="button" data-toggle="modal" data-target="#filter_modal"
                                        class="btn btn-md btn-success">
                                        <i class="fas fa-filter mr-2"></i>Filters
                                    </button>
                                </div>
                            </div>
                            <div class="rpm-card" style="position:relative;">

                                {{-- Top bar --}}
                         

                                {{-- Dashboard Stats --}}
                                <div class="rpm-dash">

                                    {{-- KPI Row --}}
                          

                                    {{-- Charts Row --}}
                      

                                    {{-- Summary Chips Panel --}}
                             
                                    {{-- Filter bar --}}
                                    <div class="rpm-filter-bar">
                                        <div class="rpm-filter-group">
                                            <label>Category</label>
                                            <select id="select_category_rpm">
                                                <option value="None">All</option>
                                                <option value="Min-Max">Low → High</option>
                                                <option value="Max-Min">High → Low</option>
                                            </select>
                                        </div>
                                        <div class="rpm-filter-group">
                                            <label>Status</label>
                                            <select id="select_status_rpm">
                                                <option value="None">All</option>
                                                <option value="Min-Max">Low → High</option>
                                                <option value="Max-Min">High → Low</option>
                                            </select>
                                        </div>
                                        <div class="rpm-filter-group">
                                            <label>Time taken</label>
                                            <select id="select_time_taken_rpm">
                                                <option value="None">All</option>
                                                <option value="Min-Max">Oldest first</option>
                                                <option value="Max-Min">Newest first</option>
                                            </select>
                                        </div>
                                        <div class="rpm-filter-group">
                                            <label>Last checked</label>
                                            <select id="select_last_checked_rpm">
                                                <option value="None">All</option>
                                                <option value="Min-Max">Oldest first</option>
                                                <option value="Max-Min">Newest first</option>
                                            </select>
                                        </div>
                                        <div class="rpm-filter-group">
                                            <label>Minutes (month)</label>
                                            <select id="select_minutes_rpm">
                                                <option value="None">All</option>
                                                <option value="Min-Max">Low → High</option>
                                                <option value="Max-Min">High → Low</option>
                                            </select>
                                        </div>
                                        <div class="rpm-filter-group">
                                            <label>Days w/ reading</label>
                                            <select id="select_days_with_reading_rpm">
                                                <option value="None">All</option>
                                                <option value="Min-Max">Low → High</option>
                                                <option value="Max-Min">High → Low</option>
                                            </select>
                                        </div>
                                        <div class="rpm-cm-group">
                                            <label>Provider</label>
                                            <span id="select_care_manager_rpm"></span>
                                        </div>
                                    </div>

                                    {{-- Active filter tag strip --}}
                                    <div class="rpm-active-tags" id="rpm-active-tags"></div>
                                    {{-- Table wrapper (spinner lives here) --}}
                                    <div class="rpm-table-wrap" style="position:relative;">
                                        <div class="rpm-spinner-overlay" id="rpm-spinner">
                                            <div class="rpm-spinner"></div>
                                        </div>

                                        <div id="rpm_patient_table_wrapper">
                                            <table id="rpm_patient_table"
                                                class="table table-striped table-bordered w-100 nowrap"
                                                data-url="{{ route('patient.index') }}"
                                                data-last-updated="{{ $lastUpdated ?? now()->toISOString() }}">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Patient</th>
                                                        <th>Avg BP</th>
                                                        <th data-id="select_category_rpm"><span
                                                                class="rpm-sort-icon">Category</span></th>
                                                        <th>Last BP</th>
                                                        <th data-id="select_status_rpm"><span
                                                                class="rpm-sort-icon">Status</span></th>
                                                        <th>Avg PR</th>
                                                        <th>Last PR</th>
                                                        <th data-id="select_time_taken_rpm"><span
                                                                class="rpm-sort-icon">Time
                                                                taken</span></th>
                                                        <th data-id="select_last_checked_rpm"><span
                                                                class="rpm-sort-icon">Last
                                                                checked</span></th>
                                                        <th data-id="select_minutes_rpm"><span class="rpm-sort-icon">Min
                                                                (month)</span></th>
                                                        <th data-id="select_days_with_reading_rpm"><span
                                                                class="rpm-sort-icon">Days read</span></th>
                                                        <th>Call done</th>
                                                        <th>Covid</th>
                                                        <th>Provider</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $sr_no = 1; @endphp
                                                    @foreach ($rpm_patients as $item)
                                                        @php
                                                            $avg_pul = floor($item->patient_data_avg_datapul);
                                                            $avg_sys = floor($item->patient_data_avg_datasys);
                                                            $avg_dia = floor($item->patient_data_avg_datadia);

                                                            $category = get_category($avg_sys, $avg_dia);
                                                            $category_order = 1;
                                                            if ($category == 'Stage-1') {
                                                                $category_order = 2;
                                                            }
                                                            if ($category == 'Stage-2') {
                                                                $category_order = 3;
                                                            }
                                                            if ($category == 'Crisis') {
                                                                $category_order = 4;
                                                            }

                                                            $status = 'Normal';
                                                            if ($item->last_patient_data) {
                                                                $status = $item->last_patient_data->category;
                                                            }
                                                            $status_order = 1;
                                                            if ($status == 'Stage-1') {
                                                                $status_order = 2;
                                                            }
                                                            if ($status == 'Stage-2') {
                                                                $status_order = 3;
                                                            }
                                                            if ($status == 'Crisis') {
                                                                $status_order = 4;
                                                            }

                                                            $current = Carbon\Carbon::now()->timestamp;
                                                            $time_taken = $current;
                                                            if ($item->last_patient_data) {
                                                                $time_taken =
                                                                    $current -
                                                                    Carbon\Carbon::parse(
                                                                        $item->last_patient_data->date_time,
                                                                    )->timestamp;
                                                            }
                                                            $last_checked = $current;
                                                            if ($item->last_checked) {
                                                                $last_checked =
                                                                    $current -
                                                                    Carbon\Carbon::parse($item->last_checked)
                                                                        ->timestamp;
                                                            }
                                                            $total_seconds =
                                                                $item->time_tracks_sum_minutes * 60 +
                                                                $item->time_tracks_sum_seconds;

                                                            $rowClass = $status === 'Crisis' ? 'rpm-crisis-row' : '';
                                                        @endphp
                                                        <tr class="{{ $rowClass }}">
                                                            <td>{{ $sr_no++ }}</td>

                                                            {{-- Patient --}}
                                                            <td>
                                                                <a
                                                                    href="{{ route('patient.show', ['patient' => $item, 'type' => 'rpm']) }}">
                                                                    {{ $item->first_name }} {{ $item->last_name }}
                                                                </a>
                                                            </td>

                                                            {{-- Avg BP --}}
                                                            <td>
                                                                <span
                                                                    class="rpm-bp {{ $category }}">{{ $avg_sys }}/{{ $avg_dia }}</span>
                                                            </td>

                                                            {{-- Category --}}
                                                            <td data-sort="{{ $category_order }}">
                                                                <span class="rpm-badge {{ $category }}">
                                                                    <span
                                                                        class="rpm-badge-dot"></span>{{ $category }}
                                                                </span>
                                                            </td>

                                                            {{-- Last BP --}}
                                                            <td>
                                                                @if ($item->last_patient_data)
                                                                    <span
                                                                        class="rpm-bp {{ $item->last_patient_data->category }}">
                                                                        {{ data_get($item->last_patient_data, 'data.sys', '—') }}/{{ data_get($item->last_patient_data, 'data.dia', '—') }}
                                                                    </span>
                                                                @else
                                                                    <span class="rpm-no-data">no data</span>
                                                                @endif
                                                            </td>

                                                            {{-- Status --}}
                                                            <td data-sort="{{ $status_order }}">
                                                                @if ($item->last_patient_data)
                                                                    <span
                                                                        class="rpm-badge {{ $item->last_patient_data->category }}">
                                                                        <span
                                                                            class="rpm-badge-dot"></span>{{ $item->last_patient_data->category }}
                                                                    </span>
                                                                @else
                                                                    <span class="rpm-no-data">no data</span>
                                                                @endif
                                                            </td>

                                                            {{-- Avg PR --}}
                                                            <td class="rpm-mono">{{ $avg_pul ?: '—' }}</td>

                                                            {{-- Last PR --}}
                                                            <td class="rpm-mono">
                                                                {{ $item->last_patient_data->data['pul'] ?? '—' }}</td>

                                                            {{-- Time taken --}}
                                                            <td data-sort="{{ $time_taken }}">
                                                                @if ($item->last_patient_data)
                                                                    <span
                                                                        class="rpm-time">{{ $item->last_patient_data->formatted_date }}</span>
                                                                @else
                                                                    <span class="rpm-no-data">no data</span>
                                                                @endif
                                                            </td>

                                                            {{-- Last checked --}}
                                                            <td data-sort="{{ $last_checked }}">
                                                                <span
                                                                    class="rpm-time">{{ $item->formatted_last_checked ?? '—' }}</span>
                                                            </td>

                                                            {{-- Minutes (month) --}}
                                                            <td data-sort="{{ $total_seconds }}">
                                                                <span
                                                                    class="rpm-time">{{ configure_time_track($item->time_tracks_sum_minutes, $item->time_tracks_sum_seconds) }}</span>
                                                            </td>

                                                            {{-- Days with reading --}}
                                                            <td class="rpm-mono">{{ $item->days_with_reading->count() }}
                                                            </td>

                                                            {{-- Completed call --}}
                                                            <td>
                                                                @if ($item->phone_call)
                                                                    <span class="rpm-call-yes">&#10003; Yes</span>
                                                                @else
                                                                    <span class="rpm-call-no">— No</span>
                                                                @endif
                                                            </td>

                                                            {{-- Covid --}}
                                                            <td style="font-size:12px; color:var(--rpm-text-secondary);">
                                                                {{ $item->covid_status ?? '—' }}
                                                            </td>

                                                            {{-- Provider --}}
                                                            <td style="font-size:12px; color:var(--rpm-text-secondary);">
                                                                {{ $item->doctor ? $item->doctor->user_name : '—' }}
                                                            </td>

                                                            {{-- Action --}}
                                                            <td>
                                                                <div class="dropdown">
                                                                    <button class="rpm-action-btn dropdown-toggle"
                                                                        type="button" data-bs-toggle="dropdown"
                                                                        aria-expanded="false">
                                                                        <svg viewBox="0 0 12 12" fill="none"
                                                                            stroke="currentColor" stroke-width="1.6"
                                                                            stroke-linecap="round">
                                                                            <circle cx="6" cy="2.5" r=".8"
                                                                                fill="currentColor" stroke="none" />
                                                                            <circle cx="6" cy="6" r=".8"
                                                                                fill="currentColor" stroke="none" />
                                                                            <circle cx="6" cy="9.5" r=".8"
                                                                                fill="currentColor" stroke="none" />
                                                                        </svg>
                                                                        Actions
                                                                    </button>
                                                                    <ul class="dropdown-menu rpm-dropdown-menu">
                                                                        <li>
                                                                            <a class="dropdown-item"
                                                                                href="{{ route('patient.show', ['patient' => $item, 'type' => 'rpm']) }}">
                                                                                <i class="ti-eye"></i> View
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a class="dropdown-item"
                                                                                href="{{ route('patient.edit', $item) }}">
                                                                                <i class="ti-pencil-alt"></i> Edit
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- unenrolled patients tab --}}
                        <div class="tab-pane {{ $unenrolled ? 'show active' : '' }}" id="unenrolled">
                            <div class="table-responsive">
                                <table id="unenrolled_patient_table" class="table table-striped table-bordered w-100">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Patient Name</th>
                                            <th>Gender</th>
                                            <th>Contact no</th>
                                            <th>Address</th>
                                            <th>Un-Enroll Note</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sr_no = 1;
                                        @endphp
                                        @foreach ($unenrolled_patients as $item)
                                            <tr>
                                                <td>{{ $sr_no++ }}</td>
                                                <td>
                                                    <a
                                                        href="{{ route('patient.show', ['patient' => $item, 'type' => 'unenrolled_patient']) }}"><strong>{{ $item->first_name }}
                                                            {{ $item->last_name }}</strong></a>
                                                </td>

                                                <td>{{ $item->gender }}</td>
                                                <td>{{ $item->contact_no }}</td>
                                                <td style="width: 300px;">{{ $item->address }}</td>
                                                <td style="width: 500px;">
                                                    <div
                                                        style="max-width: 550px; overflow-x: auto; scrollbar-width: thin; scrollbar-color: #888 #f5f5f5; height: 40px;">
                                                        {{ $item->un_enrolled_note }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-success dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="ti-settings"></i>
                                                        </button>
                                                        <div class="dropdown-menu slideInUp">
                                                            <button class="dropdown-item"
                                                                onclick="event.preventDefault();
                                                                document.getElementById('enrol_patient').submit();"><i
                                                                    class="ti-eye"></i> Enrol</button>
                                                            <form action="{{ route('patient.enrol', $item) }}"
                                                                method="post" id="enrol_patient">
                                                                @csrf
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
    </div>
@endsection
@section('modal')
    <div class="modal fade" id="filter_modal" role="dialog" aria-labelledby="large" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4>Apply Filter</h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="">Select Care Manager</label>
                                <select class="form-control" name="select_care_manager_rpm" id="select_care_manager_rpm">
                                    <option value=""> --select care manger--</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="">Select Category</label>
                                <select class="form-control" name="select_category_rpm" id="select_category_rpm">
                                    <option value="None" {{ $select_status_rpm == 'None' ? 'selected' : '' }}>
                                        --select
                                        Category--</option>
                                    <option value="Min-Max" {{ $select_category_rpm == 'Min-Max' ? 'selected' : '' }}>
                                        Min-Max</option>
                                    <option value="Max-Min" {{ $select_category_rpm == 'Max-Min' ? 'selected' : '' }}>
                                        Max-Min</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="">Select Status</label>
                                <select class="form-control" name="select_status_rpm" id="select_status_rpm">
                                    <option value="None" {{ $select_status_rpm == 'None' ? 'selected' : '' }}>
                                        --select
                                        Status--</option>
                                    <option value="Min-Max" {{ $select_status_rpm == 'Min-Max' ? 'selected' : '' }}>
                                        Min-Max</option>
                                    <option value="Max-Min" {{ $select_status_rpm == 'Max-Min' ? 'selected' : '' }}>
                                        Max-Min</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="">Select Time Taken</label>
                                <select class="form-control" name="select_time_taken_rpm" id="select_time_taken_rpm">
                                    <option value="None" {{ $select_status_rpm == 'None' ? 'selected' : '' }}>
                                        --Time
                                        Taken--</option>
                                    <option value="Min-Max" {{ $select_time_taken_rpm == 'Min-Max' ? 'selected' : '' }}>
                                        Min-Max</option>
                                    <option value="Max-Min" {{ $select_time_taken_rpm == 'Max-Min' ? 'selected' : '' }}>
                                        Max-Min</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="">Select Last Checked</label>
                                <select class="form-control" name="select_last_checked_rpm" id="select_last_checked_rpm">
                                    <option value="None" {{ $select_status_rpm == 'None' ? 'selected' : '' }}>
                                        --Last
                                        Checked--</option>
                                    <option value="Min-Max"
                                        {{ $select_last_checked_rpm == 'Min-Max' ? 'selected' : '' }}>Min-Max</option>
                                    <option value="Max-Min"
                                        {{ $select_last_checked_rpm == 'Max-Min' ? 'selected' : '' }}>Max-Min</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="">Select Min This Month</label>
                                <select class="form-control" name="select_minutes_rpm" id="select_minutes_rpm">
                                    <option value="None" {{ $select_minutes_rpm == 'None' ? 'selected' : '' }}>
                                        --Min
                                        This Month--</option>
                                    <option value="Min-Max" {{ $select_minutes_rpm == 'Min-Max' ? 'selected' : '' }}>
                                        Min-Max</option>
                                    <option value="Max-Min" {{ $select_minutes_rpm == 'Max-Min' ? 'selected' : '' }}>
                                        Max-Min</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="">Select Days With Reading</label>
                                <select class="form-control" name="select_days_with_reading_rpm"
                                    id="select_days_with_reading_rpm">
                                    <option value="None"
                                        {{ $select_days_with_reading_rpm == 'None' ? 'selected' : '' }}> --Days With
                                        Reading--</option>
                                    <option value="Min-Max"
                                        {{ $select_days_with_reading_rpm == 'Min-Max' ? 'selected' : '' }}>Min-Max
                                    </option>
                                    <option value="Max-Min"
                                        {{ $select_days_with_reading_rpm == 'Max-Min' ? 'selected' : '' }}>Max-Min
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <form action="{{ route('reset.rpm.sort') }}" method="post">
                                    @csrf
                                    <button class="btn btn-danger" type="submit">
                                        <i class="fa fa-filter mr-1" aria-hidden="true"></i>Clear
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="rpm_reset_modal" role="dialog" aria-labelledby="large" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4>Are You Sure?</h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('setting.rpm') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-primary">Yes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('datatable/datatables.min.js') }}"></script>



    <script>
        var rpm_table;
        var _rpmCharts = {};

        $(document).ready(function() {

            rpm_table = $('#rpm_patient_table').DataTable({
                "dom": '<lBf<t>ip>',
                buttons: ['excel', 'print'],
                responsive: true,
                pageLength: 100,
                order: [
                    [8, 'asc']
                ],
                initComplete: function() {
                    rpmUpdateCountBadge();
                    rpmWireProviderSelect(this.api());
                    rpmWireFilterSelects();
                }
            });

            rpm_table.on('draw', function() {
                rpmUpdateCountBadge();
            });

            // ── FIX 2: Wire the 6 filter-bar selects to DataTable column sort ──
            function rpmWireFilterSelects() {
                var map = [{
                        id: 'select_category_rpm',
                        col: 3
                    },
                    {
                        id: 'select_status_rpm',
                        col: 5
                    },
                    {
                        id: 'select_time_taken_rpm',
                        col: 8
                    },
                    {
                        id: 'select_last_checked_rpm',
                        col: 9
                    },
                    {
                        id: 'select_minutes_rpm',
                        col: 10
                    },
                    {
                        id: 'select_days_with_reading_rpm',
                        col: 11
                    },
                ];
                map.forEach(function(m) {
                    $('#' + m.id).off('change').on('change', function() {
                        var val = $(this).val();
                        if (val === 'None') {
                            rpm_table.order([8, 'asc']).draw();
                        } else {
                            rpm_table.order([m.col, val === 'Min-Max' ? 'asc' : 'desc']).draw();
                        }
                        rpmUpdateCountBadge();
                        rpmSyncActiveFilterTags();
                    });
                });
            }

            // ── FIX 2: Show active sort tags in the strip ──
            function rpmSyncActiveFilterTags() {
                var labels = {
                    select_category_rpm: 'Category',
                    select_status_rpm: 'Status',
                    select_time_taken_rpm: 'Time taken',
                    select_last_checked_rpm: 'Last checked',
                    select_minutes_rpm: 'Minutes',
                    select_days_with_reading_rpm: 'Days',
                };
                var $strip = $('#rpm-active-tags').empty();
                Object.keys(labels).forEach(function(id) {
                    var val = $('#' + id).val();
                    if (!val || val === 'None') return;
                    $strip.append(
                        $('<span>').text(labels[id] + (val === 'Min-Max' ? ' ↑' : ' ↓'))
                        .css({
                            display: 'inline-flex',
                            alignItems: 'center',
                            fontSize: '11px',
                            padding: '2px 8px',
                            borderRadius: '20px',
                            marginRight: '6px',
                            background: 'rgba(59,130,246,.15)',
                            color: '#3b82f6',
                            cursor: 'pointer'
                        })
                        .on('click', function() {
                            $('#' + id).val('None').trigger('change');
                        })
                    );
                });
            }

            // ── Provider select (column 14) ──
            function rpmWireProviderSelect(api) {
                $('#select_care_manager_rpm').empty();
                var select = $('<select><option value="">All providers</option></select>')
                    .appendTo('#select_care_manager_rpm')
                    .on('change', function() {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        api.column(14).search(val ? '^' + val + '$' : '', true, false).draw();
                        rpmUpdateCountBadge();
                    });
                api.column(14).data().unique().sort().each(function(d) {
                    var val = $('<div>').html(d).text().trim();
                    select.append('<option value="' + val + '">' + val + '</option>');
                });
            }

            // ── FIX 3: Reload function — rebuilds table AND charts ──
            function rpmReload() {
                $('#rpm-spinner').addClass('active');
                rpmSpinRefreshIcon(true);

                $.ajax({
                    url: $('#rpm_patient_table').data('url'),
                    type: 'GET',
                    success: function(response) {
                        var $res = $(response);

                        // Rebuild table
                        rpm_table.destroy();
                        $('#rpm_patient_table_wrapper').html($res.find('#rpm_patient_table_wrapper')
                            .html());

                        rpm_table = $('#rpm_patient_table').DataTable({
                            "dom": '<lBf<t>ip>',
                            buttons: ['excel', 'print'],
                            responsive: true,
                            pageLength: 100,
                            order: [
                                [8, 'asc']
                            ],
                            initComplete: function() {
                                rpmUpdateCountBadge();
                                rpmWireProviderSelect(this.api());
                                rpmWireFilterSelects();
                            }
                        });
                        rpm_table.on('draw', function() {
                            rpmUpdateCountBadge();
                        });

                        // FIX 3: parse fresh stats and rebuild all charts
                        var statsRaw = $res.find('#rpm-stats-json').text();
                        if (statsRaw) {
                            try {
                                rpmRebuildCharts(JSON.parse(statsRaw));
                            } catch (e) {
                                console.warn('RPM stats JSON parse error', e);
                            }
                        }

                        rpmUpdateLastUpdated();
                        $('#rpm-spinner').removeClass('active');
                        rpmSpinRefreshIcon(false);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error reloading RPM table:', error);
                        $('#rpm-spinner').removeClass('active');
                        rpmSpinRefreshIcon(false);
                    }
                });
            }

            setInterval(rpmReload, 600000);
            $('#rpm-manual-refresh').on('click', function() {
                rpmReload();
            });

            var initialTs = $('#rpm_patient_table').data('last-updated');
            if (initialTs) rpmSetLastUpdated(new Date(initialTs));
        });

        // ── Last-updated helpers ──
        var _rpmLastUpdatedDate = null;
        var _rpmRelativeTimer = null;

        function rpmSetLastUpdated(date) {
            _rpmLastUpdatedDate = date;
            rpmRenderRelative();
            clearInterval(_rpmRelativeTimer);
            _rpmRelativeTimer = setInterval(rpmRenderRelative, 30000);
        }

        function rpmUpdateLastUpdated() {
            rpmSetLastUpdated(new Date());
        }

        function rpmRenderRelative() {
            if (!_rpmLastUpdatedDate) return;
            var diff = Math.floor((Date.now() - _rpmLastUpdatedDate.getTime()) / 1000);
            var text = diff < 60 ? 'just now' :
                diff < 3600 ? Math.floor(diff / 60) + ' min ago' :
                diff < 86400 ? Math.floor(diff / 3600) + ' hr ago' :
                Math.floor(diff / 86400) + ' d ago';
            $('#rpm-last-updated-text').text(text);
        }

        function rpmSpinRefreshIcon(on) {
            var btn = $('#rpm-manual-refresh');
            if (on) btn.addClass('spinning').prop('disabled', true);
            else btn.removeClass('spinning').prop('disabled', false);
        }

        // ── Patient count badge ──
        function rpmUpdateCountBadge() {
            if (!rpm_table) return;
            var filtered = rpm_table.rows({
                search: 'applied'
            }).count();
            var total = rpm_table.rows().count();
            $('#rpm-count-num').text(filtered < total ? filtered + ' / ' + total : total);
        }

        // ── Summary chip filter ──
        function rpmSummaryFilter(type, value) {
            if (!rpm_table) return;
            if (type === 'category') {
                var col = rpm_table.column(3);
                col.search(col.search() === '^' + value + '$' ? '' : '^' + value + '$', true, false).draw();
            } else if (type === 'status') {
                var col = rpm_table.column(5);
                col.search(col.search() === '^' + value + '$' ? '' : '^' + value + '$', true, false).draw();
            } else if (type === 'nodata') {
                rpm_table.search(rpm_table.search() === 'no data' ? '' : 'no data').draw();
            }
            rpmUpdateCountBadge();
            document.getElementById('rpm_patient_table_wrapper')
                .scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
        }

        // ── FIX 3: single chart build function used by both page load AND reload ──
        function rpmRebuildCharts(s) {
            var C_NORMAL = '#34c787',
                C_S1 = '#f6c94e',
                C_S2 = '#f49b35',
                C_CRISIS = '#fb1031',
                C_NONE = 'rgba(255,255,255,.08)';

            var DONUT = {
                cutout: '72%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: false
                    }
                },
                animation: {
                    animateRotate: true,
                    duration: 700
                },
            };

            function rebuildDonut(id, data, colors) {
                if (_rpmCharts[id]) {
                    _rpmCharts[id].destroy();
                    delete _rpmCharts[id];
                }
                var ctx = document.getElementById(id);
                if (!ctx) return;
                _rpmCharts[id] = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        datasets: [{
                            data: data,
                            backgroundColor: colors,
                            borderWidth: 0,
                            spacing: 2,
                            borderRadius: 3
                        }]
                    },
                    options: DONUT,
                });
            }

            // Avg BP Category donut
            rebuildDonut('rpmAvgBpChart',
                [s.summaryNormal, s.summaryS1, s.summaryS2, s.summaryCrisis, Math.max(0, s.noData)],
                [C_NORMAL, C_S1, C_S2, C_CRISIS, C_NONE]);

            // Last BP Status donut
            rebuildDonut('rpmLastBpChart',
                [s.statusNormal, s.statusS1, s.statusS2, s.statusCrisis, Math.max(0, s.noData)],
                [C_NORMAL, C_S1, C_S2, C_CRISIS, C_NONE]);

            // Mins Tracked donut — FIX 1: 4th segment = noMins (reading exists, 0 mins tracked)
            rebuildDonut('rpmMinsChart',
                [s.aboveGoal, s.nearGoal, s.belowGoal, Math.max(0, s.noMins)],
                [C_NORMAL, C_S1, C_S2, C_NONE]);

            // Per-patient bar chart
            if (_rpmCharts['rpmPerPatientChart']) {
                _rpmCharts['rpmPerPatientChart'].destroy();
                delete _rpmCharts['rpmPerPatientChart'];
            }
            var barCtx = document.getElementById('rpmPerPatientChart');
            if (barCtx && s.perPatient) {
                var names = s.perPatient.map(function(p) {
                    return p.name;
                });
                var mins = s.perPatient.map(function(p) {
                    return p.mins;
                });
                var colours = mins.map(function(m) {
                    return m >= 20 ? C_NORMAL : m >= 12 ? C_S1 : C_S2;
                });
                _rpmCharts['rpmPerPatientChart'] = new Chart(barCtx, {
                    type: 'bar',
                    data: {
                        labels: names,
                        datasets: [{
                            data: mins,
                            backgroundColor: colours,
                            borderRadius: 3,
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(c) {
                                        return c.parsed.y + ' min';
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                ticks: {
                                    color: 'rgba(255,255,255,.45)',
                                    font: {
                                        size: 9
                                    },
                                    maxRotation: 0
                                },
                                grid: {
                                    display: false
                                },
                                border: {
                                    display: false
                                }
                            },
                            y: {
                                ticks: {
                                    color: 'rgba(255,255,255,.35)',
                                    font: {
                                        size: 9
                                    },
                                    callback: function(v) {
                                        return v + 'm';
                                    },
                                    stepSize: 10
                                },
                                grid: {
                                    color: 'rgba(255,255,255,.05)'
                                },
                                border: {
                                    display: false
                                },
                                suggestedMax: 30
                            }
                        }
                    }
                });
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>

    <script>
        $(document).ready(function() {
            try {
                var raw = document.getElementById('rpm-stats-json').textContent;
                rpmRebuildCharts(JSON.parse(raw));
            } catch (e) {
                console.error('Initial RPM chart build failed', e);
            }
        });
    </script>

    {{-- RPM stats for JS chart rebuild on AJAX reload --}}
    <script id="rpm-stats-json" type="application/json">
{
    "summaryNormal": {{ $summaryNormal }},
    "summaryS1":     {{ $summaryS1 }},
    "summaryS2":     {{ $summaryS2 }},
    "summaryCrisis": {{ $summaryCrisis }},
    "statusNormal":  {{ $statusNormal }},
    "statusS1":      {{ $statusS1 }},
    "statusS2":      {{ $statusS2 }},
    "statusCrisis":  {{ $statusCrisis }},
    "noData":        {{ $noData }},
    "aboveGoal":     {{ $aboveGoal }},
    "nearGoal":      {{ $nearGoal }},
    "belowGoal":     {{ $belowGoal }},
    "noMins":        {{ $noMins }},
    "perPatient":    @json($rpm_patients->map(fn($p) => ['name' => $p->first_name, 'mins' => (int)($p->time_tracks_sum_minutes ?? 0)])->values())
}
</script>








    {{-- ── Script 2: Unenrolled table (unchanged) ── --}}
    <script>
        $(document).ready(function() {
            $('#unenrolled_patient_table').DataTable({
                "dom": '<lBf<t>ip>',
                buttons: ['excel', 'print'],
                responsive: true,
                pageLength: 10,
                order: [
                    [0, 'asc']
                ]
            });
        });
    </script>

    {{-- ── Script 3: CCM table + all filter/sort handlers ── --}}
    <script>
        /* FIX 1: removed duplicate rpm_table declaration */
        var ccm_table;

        $(document).ready(function() {
            if (window.location.hash) {
                var hash = window.location.hash.substring(1);
                if (hash === "rpm") $('#rpm_link').trigger('click');
                else $('#ccm_link').trigger('click');
            }

            ccm_table = $('#ccm_patient_table').DataTable({
                "dom": '<lBf<t>ip>',
                buttons: ['excel', 'print'],
                responsive: true,
                pageLength: 10,
                initComplete: function() {
                    this.api().columns('6').every(function() {
                        var target = "#select_care_manager_ccm";
                        var column = this;
                        var select = $('#select_care_manager_ccm')
                            .appendTo(target)
                            .on('change', function() {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                column.search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                            });
                        column.data().unique().sort().each(function(d) {
                            var val = extractContent(d);
                            select.append('<option value="' + val + '">' + val +
                                '</option>');
                        });
                    });
                }
            });

            /* ── Restore session filter values ─────────────────────── */
            var select_covid_status_ccm = "{{ $select_covid_status_ccm }}";
            if (select_covid_status_ccm != "None") filter_select_covid_status_ccm(select_covid_status_ccm);

            var select_gender_ccm = "{{ $select_gender_ccm }}";
            if (select_gender_ccm != "None") filter_select_gender_ccm(select_gender_ccm);

            var select_last_ccm_performed = "{{ $select_last_ccm_performed }}";
            if (select_last_ccm_performed != "None") filter_select_last_ccm_performed(select_last_ccm_performed);

            var select_category_rpm = "{{ $select_category_rpm }}";
            if (select_category_rpm != "None") {
                $('#select_category_rpm').val(select_category_rpm);
                filter_select_category_rpm(select_category_rpm);
                rpmMarkSelectActive('select_category_rpm', select_category_rpm);
            }

            var select_status_rpm = "{{ $select_status_rpm }}";
            if (select_status_rpm != "None") {
                $('#select_status_rpm').val(select_status_rpm);
                filter_select_status_rpm(select_status_rpm);
                rpmMarkSelectActive('select_status_rpm', select_status_rpm);
            }

            var select_time_taken_rpm = "{{ $select_time_taken_rpm }}";
            if (select_time_taken_rpm != "None") {
                $('#select_time_taken_rpm').val(select_time_taken_rpm);
                filter_select_time_taken_rpm(select_time_taken_rpm);
                rpmMarkSelectActive('select_time_taken_rpm', select_time_taken_rpm);
            }

            var select_last_checked_rpm = "{{ $select_last_checked_rpm }}";
            if (select_last_checked_rpm != "None") {
                $('#select_last_checked_rpm').val(select_last_checked_rpm);
                filter_select_last_checked_rpm(select_last_checked_rpm);
                rpmMarkSelectActive('select_last_checked_rpm', select_last_checked_rpm);
            }

            var select_minutes_rpm = "{{ $select_minutes_rpm }}";
            if (select_minutes_rpm != "None") {
                $('#select_minutes_rpm').val(select_minutes_rpm);
                filter_select_minutes_rpm(select_minutes_rpm);
                rpmMarkSelectActive('select_minutes_rpm', select_minutes_rpm);
            }

            var select_days_with_reading_rpm = "{{ $select_days_with_reading_rpm }}";
            if (select_days_with_reading_rpm != "None") {
                $('#select_days_with_reading_rpm').val(select_days_with_reading_rpm);
                filter_select_days_with_reading_rpm(select_days_with_reading_rpm);
                rpmMarkSelectActive('select_days_with_reading_rpm', select_days_with_reading_rpm);
            }

            rpmRenderActiveTags();
        });

        /* ── Tab click handlers (unchanged) ─────────────────────────── */
        $('#rpm_patient_table thead').on('click', 'th', function() {
            var key = $(this).attr('data-id');
            if (key) {
                var value = $(this).hasClass('sorting_desc') ? "Max-Min" : "Min-Max";
                sort(key, value, "rpm");
                $('#' + key).val(value);
            }
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function() {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });

        $('#ccm_link').click(function() {
            active_tab('ccm', true);
        });
        $('#rpm_link').click(function() {
            active_tab('rpm', true);
        });
        $('#unenrolled_link').click(function() {
            active_tab('unenrolled', true);
        });

        function active_tab(key, value) {
            $.ajax({
                url: "{{ route('custom.sort') }}",
                type: "post",
                data: {
                    key,
                    value,
                    type: "tab"
                },
                success: function() {}
            });
        }

        function sort(key, value, type) {
            $.ajax({
                url: "{{ route('custom.sort') }}",
                type: "post",
                data: {
                    key,
                    value,
                    type
                },
                success: function() {}
            });
        }

        /* ── Active filter tags UI ──────────────────────────────────── */
        var rpmFilterLabels = {
            select_category_rpm: 'Category',
            select_status_rpm: 'Status',
            select_time_taken_rpm: 'Time taken',
            select_last_checked_rpm: 'Last checked',
            select_minutes_rpm: 'Minutes',
            select_days_with_reading_rpm: 'Days reading'
        };
        var rpmFilterValues = {
            select_category_rpm: 'None',
            select_status_rpm: 'None',
            select_time_taken_rpm: 'None',
            select_last_checked_rpm: 'None',
            select_minutes_rpm: 'None',
            select_days_with_reading_rpm: 'None'
        };
        var rpmValueLabels = {
            'Min-Max': 'Low→High',
            'Max-Min': 'High→Low',
            'None': ''
        };

        function rpmMarkSelectActive(id, value) {
            var el = document.getElementById(id);
            if (!el) return;
            if (value && value !== 'None') el.classList.add('active');
            else el.classList.remove('active');
        }

        function rpmRenderActiveTags() {
            var container = $('#rpm-active-tags');
            container.empty();
            var hasAny = false;
            $.each(rpmFilterValues, function(id, val) {
                if (val && val !== 'None') {
                    hasAny = true;
                    var label = rpmFilterLabels[id] || id;
                    var vlabel = rpmValueLabels[val] || val;
                    var tag = $(
                        '<span class="rpm-tag">' +
                        label + ': ' + vlabel +
                        '<span class="rpm-tag-x" data-filter-id="' + id + '">&#x2715;</span>' +
                        '</span>'
                    );
                    container.append(tag);
                }
            });
            if (hasAny) {
                var clearAll = $('<span class="rpm-clear-all">Clear all</span>');
                clearAll.on('click', rpmClearAllFilters);
                container.prepend('<span class="rpm-active-tags-label">Active:</span>');
                container.append(clearAll);
            }
        }

        $(document).on('click', '.rpm-tag-x', function() {
            var id = $(this).data('filter-id');
            $('#' + id).val('None').trigger('change');
        });

        function rpmClearAllFilters() {
            $.each(rpmFilterValues, function(id) {
                if (rpmFilterValues[id] !== 'None') {
                    $('#' + id).val('None').trigger('change');
                }
            });
        }

        /* ── CCM filter handlers (unchanged) ───────────────────────── */
        $('#select_last_ccm_performed').on('change', function() {
            var value = $(this).val();
            sort("select_last_ccm_performed", value, "ccm");
            filter_select_last_ccm_performed(value);
        });

        function filter_select_last_ccm_performed(search) {
            var date = new Date();
            var month = date.getMonth() + 1;
            var day = date.getDate();
            if (search == "Yesterday") day = day - 1;
            if (day < 9) day = "0" + day;
            var today = month + "-" + day;
            var yesterday = month + "-" + day;
            var pattern = "";
            if (search) {
                if (search == "Today") pattern = today;
                if (search == "Yesterday") pattern = yesterday;
                if (search == "This-Month") pattern = month;
                if (search == "Prev-Month") pattern = month - 1;
                ccm_table.column(8).search(pattern, true, false).draw();
            } else {
                ccm_table.search('').columns().search('').draw();
            }
        }
        $('#select_gender_ccm').on('change', function() {
            var value = $(this).val();
            sort("select_gender_ccm", value, "ccm");
            filter_select_gender_ccm(value);
        });

        function filter_select_gender_ccm(search) {
            if (search) ccm_table.column(3).search("(^" + search + "$)", true, false).draw();
            else ccm_table.search('').columns().search('').draw();
        }
        $('#select_covid_status_ccm').on('change', function() {
            var value = $(this).val();
            sort("select_covid_status_ccm", value, "ccm");
            filter_select_covid_status_ccm(value);
        });

        function filter_select_covid_status_ccm(search) {
            if (search) ccm_table.column(2).search("(^" + search + "$)", true, false).draw();
            else ccm_table.search('').columns().search('').draw();
        }

        /* ── RPM sort handlers (sort order identical, UX layer added) ── */
        $('#select_category_rpm').change(function() {
            var value = $(this).val();
            sort("select_category_rpm", value, "rpm");
            rpmFilterValues['select_category_rpm'] = value;
            rpmMarkSelectActive('select_category_rpm', value);
            rpmRenderActiveTags();
            filter_select_category_rpm(value);
        });

        function filter_select_category_rpm(value) {
            switch (value) {
                case "None":
                    rpm_table.order([0, 'asc']).draw();
                    break;
                case "Min-Max":
                    rpm_table.order([3, 'asc']).draw();
                    break;
                case "Max-Min":
                    rpm_table.order([3, 'desc']).draw();
                    break;
            }
        }

        $('#select_status_rpm').change(function() {
            var value = $(this).val();
            sort("select_status_rpm", value, "rpm");
            rpmFilterValues['select_status_rpm'] = value;
            rpmMarkSelectActive('select_status_rpm', value);
            rpmRenderActiveTags();
            filter_select_status_rpm(value);
        });

        function filter_select_status_rpm(value) {
            switch (value) {
                case "None":
                    rpm_table.order([0, 'asc']).draw();
                    break;
                case "Min-Max":
                    rpm_table.order([5, 'asc']).draw();
                    break;
                case "Max-Min":
                    rpm_table.order([5, 'desc']).draw();
                    break;
            }
        }

        $('#select_time_taken_rpm').change(function() {
            var value = $(this).val();
            sort("select_time_taken_rpm", value, "rpm");
            rpmFilterValues['select_time_taken_rpm'] = value;
            rpmMarkSelectActive('select_time_taken_rpm', value);
            rpmRenderActiveTags();
            filter_select_time_taken_rpm(value);
        });

        function filter_select_time_taken_rpm(value) {
            switch (value) {
                case "None":
                    rpm_table.order([0, 'asc']).draw();
                    break;
                case "Min-Max":
                    rpm_table.order([8, 'asc']).draw();
                    break;
                case "Max-Min":
                    rpm_table.order([8, 'desc']).draw();
                    break;
            }
        }

        $('#select_last_checked_rpm').change(function() {
            var value = $(this).val();
            sort("select_last_checked_rpm", value, "rpm");
            rpmFilterValues['select_last_checked_rpm'] = value;
            rpmMarkSelectActive('select_last_checked_rpm', value);
            rpmRenderActiveTags();
            filter_select_last_checked_rpm(value);
        });

        function filter_select_last_checked_rpm(value) {
            switch (value) {
                case "None":
                    rpm_table.order([0, 'asc']).draw();
                    break;
                case "Min-Max":
                    rpm_table.order([9, 'asc']).draw();
                    break;
                case "Max-Min":
                    rpm_table.order([9, 'desc']).draw();
                    break;
            }
        }

        $('#select_minutes_rpm').change(function() {
            var value = $(this).val();
            sort("select_minutes_rpm", value, "rpm");
            rpmFilterValues['select_minutes_rpm'] = value;
            rpmMarkSelectActive('select_minutes_rpm', value);
            rpmRenderActiveTags();
            filter_select_minutes_rpm(value);
        });

        function filter_select_minutes_rpm(value) {
            switch (value) {
                case "None":
                    rpm_table.order([0, 'asc']).draw();
                    break;
                case "Min-Max":
                    rpm_table.order([10, 'asc']).draw();
                    break;
                case "Max-Min":
                    rpm_table.order([10, 'desc']).draw();
                    break;
            }
        }

        $('#select_days_with_reading_rpm').change(function() {
            var value = $(this).val();
            sort("select_days_with_reading_rpm", value, "rpm");
            rpmFilterValues['select_days_with_reading_rpm'] = value;
            rpmMarkSelectActive('select_days_with_reading_rpm', value);
            rpmRenderActiveTags();
            filter_select_days_with_reading_rpm(value);
        });

        function filter_select_days_with_reading_rpm(value) {
            switch (value) {
                case "None":
                    rpm_table.order([0, 'asc']).draw();
                    break;
                case "Min-Max":
                    rpm_table.order([11, 'asc']).draw();
                    break;
                case "Max-Min":
                    rpm_table.order([11, 'desc']).draw();
                    break;
            }
        }
    </script>
@endsection
