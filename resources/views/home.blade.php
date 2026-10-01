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




                        {{-- rpm patients tab --}}



                        <div class="tab-pane {{ $rpm ? 'show active' : '' }}" id="rpm">

                            {{-- Date range bar --}}
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
                                <!--<div class="rpm-topbar">-->
                                <!--    <div class="rpm-topbar-left">-->
                                <!--        <h6 class="rpm-title">RPM Patients</h6>-->
                                <!--        <span class="rpm-patient-count" id="rpm-count-badge">-->
                                <!--            <svg width="11" height="11" viewBox="0 0 11 11" fill="none">-->
                                <!--                <circle cx="5.5" cy="3.5" r="2" stroke="currentColor"-->
                                <!--                    stroke-width="1.3" />-->
                                <!--                <path d="M1.5 9.5c0-2.2 1.8-4 4-4s4 1.8 4 4" stroke="currentColor"-->
                                <!--                    stroke-width="1.3" stroke-linecap="round" />-->
                                <!--            </svg>-->
                                <!--            <span id="rpm-count-num">—</span> patients-->
                                <!--        </span>-->
                                <!--    </div>-->
                                <!--    <div class="rpm-refresh-area">-->
                                <!--        <span class="rpm-last-updated">Updated <span-->
                                <!--                id="rpm-last-updated-text">—</span></span>-->
                                <!--        <button class="rpm-refresh-btn" id="rpm-manual-refresh" type="button">-->
                                <!--            <svg viewBox="0 0 14 14" fill="none" stroke="currentColor"-->
                                <!--                stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">-->
                                <!--                <path d="M12.5 7A5.5 5.5 0 1 1 9.5 2.3" />-->
                                <!--                <path d="M9.5 1v2.8H12.3" />-->
                                <!--            </svg>-->
                                <!--            Refresh-->
                                <!--        </button>-->
                                <!--    </div>-->
                                <!--</div>-->

                                {{-- Dashboard Stats --}}
                                <div class="rpm-dash">

                                    {{-- KPI Row --}}
                                    <!--<div class="rpm-kpi-row">-->
                                    <!--    <div class="rpm-kpi-card">-->
                                    <!--        <div class="rpm-kpi-label">Total Patients</div>-->
                                    <!--        <div class="rpm-kpi-value" id="kpi-total">—</div>-->
                                    <!--        <div class="rpm-kpi-sub">Active this month</div>-->
                                    <!--        <div class="rpm-kpi-bar" style="--w:100%; --c:#3b82f6"></div>-->
                                    <!--    </div>-->
                                    <!--    <div class="rpm-kpi-card rpm-kpi-crisis">-->
                                    <!--        <div class="rpm-kpi-label">Crisis Patients</div>-->
                                    <!--        <div class="rpm-kpi-value" id="kpi-crisis">—</div>-->
                                    <!--        <div class="rpm-kpi-sub" id="kpi-crisis-sub">—</div>-->
                                    <!--        <div class="rpm-kpi-bar" id="kpi-crisis-bar" style="--w:0%; --c:#ef4444">-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                    <!--    <div class="rpm-kpi-card">-->
                                    <!--        <div class="rpm-kpi-label">Calls Completed</div>-->
                                    <!--        <div class="rpm-kpi-value" id="kpi-calls">—</div>-->
                                    <!--        <div class="rpm-kpi-sub" id="kpi-calls-sub" style="color:#3b82f6">—</div>-->
                                    <!--        <div class="rpm-kpi-bar" id="kpi-calls-bar" style="--w:0%; --c:#3b82f6">-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                    <!--    <div class="rpm-kpi-card">-->
                                    <!--        <div class="rpm-kpi-label">No Readings</div>-->
                                    <!--        <div class="rpm-kpi-value" id="kpi-nodata">—</div>-->
                                    <!--        <div class="rpm-kpi-sub">Missing BP data</div>-->
                                    <!--        <div class="rpm-kpi-bar" id="kpi-nodata-bar" style="--w:0%; --c:#94a3b8">-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                    <!--</div>-->

                                    {{-- Charts Row --}}
                                    <!--<div class="rpm-charts-row">-->

                                     
                                    <!--    <div class="rpm-chart-card">-->
                                    <!--        <div class="rpm-chart-title">Avg BP Category</div>-->
                                    <!--        <div class="rpm-donut-wrap">-->
                                    <!--            <canvas id="rpmAvgBpChart" width="138" height="138"></canvas>-->
                                    <!--            <div class="rpm-donut-center">-->
                                    <!--                <span class="rpm-donut-num" id="donut-withdata-avg">—</span>-->
                                    <!--                <span class="rpm-donut-lbl">with data</span>-->
                                    <!--            </div>-->
                                    <!--        </div>-->
                                    <!--        <div class="rpm-chart-legend">-->
                                    <!--            <span class="rpm-leg-item">-->
                                    <!--                <span class="rpm-leg-dot" style="background:#34c787"></span>-->
                                    <!--                Normal <strong id="leg-avg-normal">—</strong>-->
                                    <!--            </span>-->
                                    <!--            <span class="rpm-leg-item">-->
                                    <!--                <span class="rpm-leg-dot" style="background:#f6c94e"></span>-->
                                    <!--                Stage-1 <strong id="leg-avg-s1">—</strong>-->
                                    <!--            </span>-->
                                    <!--            <span class="rpm-leg-item">-->
                                    <!--                <span class="rpm-leg-dot" style="background:#f49b35"></span>-->
                                    <!--                Stage-2 <strong id="leg-avg-s2">—</strong>-->
                                    <!--            </span>-->
                                    <!--            <span class="rpm-leg-item">-->
                                    <!--                <span class="rpm-leg-dot" style="background:#ef4444"></span>-->
                                    <!--                Crisis <strong id="leg-avg-crisis">—</strong>-->
                                    <!--            </span>-->
                                    <!--        </div>-->
                                    <!--    </div>-->

                                    <!--    {{-- Last BP Status --}}-->
                                    <!--    <div class="rpm-chart-card">-->
                                    <!--        <div class="rpm-chart-title">Last BP Status</div>-->
                                    <!--        <div class="rpm-donut-wrap">-->
                                    <!--            <canvas id="rpmLastBpChart" width="138" height="138"></canvas>-->
                                    <!--            <div class="rpm-donut-center">-->
                                    <!--                <span class="rpm-donut-num" id="donut-withdata-last">—</span>-->
                                    <!--                <span class="rpm-donut-lbl">with data</span>-->
                                    <!--            </div>-->
                                    <!--        </div>-->
                                    <!--        <div class="rpm-chart-legend">-->
                                    <!--            <span class="rpm-leg-item">-->
                                    <!--                <span class="rpm-leg-dot" style="background:#34c787"></span>-->
                                    <!--                Normal <strong id="leg-last-normal">—</strong>-->
                                    <!--            </span>-->
                                    <!--            <span class="rpm-leg-item">-->
                                    <!--                <span class="rpm-leg-dot" style="background:#f6c94e"></span>-->
                                    <!--                Stage-1 <strong id="leg-last-s1">—</strong>-->
                                    <!--            </span>-->
                                    <!--            <span class="rpm-leg-item">-->
                                    <!--                <span class="rpm-leg-dot" style="background:#f49b35"></span>-->
                                    <!--                Stage-2 <strong id="leg-last-s2">—</strong>-->
                                    <!--            </span>-->
                                    <!--            <span class="rpm-leg-item">-->
                                    <!--                <span class="rpm-leg-dot" style="background:#ef4444"></span>-->
                                    <!--                Crisis <strong id="leg-last-crisis">—</strong>-->
                                    <!--            </span>-->
                                    <!--        </div>-->
                                    <!--    </div>-->

                                    <!--    {{-- Mins Tracked --}}-->
                                    <!--    <div class="rpm-chart-card">-->
                                    <!--        <div class="rpm-chart-title">Mins Tracked (Month)</div>-->
                                    <!--        <div class="rpm-donut-wrap">-->
                                    <!--            <canvas id="rpmMinsChart" width="138" height="138"></canvas>-->
                                    <!--            <div class="rpm-donut-center">-->
                                    <!--                <span class="rpm-donut-num" id="donut-totalmins">—</span>-->
                                    <!--                <span class="rpm-donut-lbl">total min</span>-->
                                    <!--            </div>-->
                                    <!--        </div>-->
                                    <!--        <div class="rpm-chart-legend">-->
                                    <!--            <span class="rpm-leg-item">-->
                                    <!--                <span class="rpm-leg-dot" style="background:#34c787"></span>-->
                                    <!--                Above goal (≥20m) <strong id="leg-mins-above">—</strong>-->
                                    <!--            </span>-->
                                    <!--            <span class="rpm-leg-item">-->
                                    <!--                <span class="rpm-leg-dot" style="background:#f6c94e"></span>-->
                                    <!--                Near goal (12–19m) <strong id="leg-mins-near">—</strong>-->
                                    <!--            </span>-->
                                    <!--            <span class="rpm-leg-item">-->
                                    <!--                <span class="rpm-leg-dot" style="background:#f49b35"></span>-->
                                    <!--                Below goal (&lt;12m) <strong id="leg-mins-below">—</strong>-->
                                    <!--            </span>-->
                                    <!--            <span class="rpm-leg-item">-->
                                    <!--                <span class="rpm-leg-dot"-->
                                    <!--                    style="background:rgba(255,255,255,.15)"></span>-->
                                    <!--                No time tracked <strong id="leg-mins-none">—</strong>-->
                                    <!--            </span>-->
                                    <!--        </div>-->
                                    <!--    </div>-->

                                    <!--    {{-- Per-Patient Minutes Bar --}}-->
                                    <!--    <div class="rpm-chart-card rpm-chart-bar-card">-->
                                    <!--        <div class="rpm-chart-title">Per-Patient Minutes</div>-->
                                    <!--        <div class="rpm-bar-wrap">-->
                                    <!--            <canvas id="rpmPerPatientChart" height="110"></canvas>-->
                                    <!--        </div>-->
                                    <!--        <div class="rpm-bar-stats">-->
                                    <!--            <div class="rpm-bar-stat">-->
                                    <!--                <span class="rpm-bar-stat-lbl">Avg per patient</span>-->
                                    <!--                <span class="rpm-bar-stat-val" id="bar-avg-per-patient">—</span>-->
                                    <!--            </div>-->
                                    <!--            <div class="rpm-bar-stat">-->
                                    <!--                <span class="rpm-bar-stat-lbl">Goal (20 min)</span>-->
                                    <!--                <span class="rpm-bar-stat-val" id="bar-below-target">—</span>-->
                                    <!--            </div>-->
                                    <!--            <div class="rpm-bar-stat">-->
                                    <!--                <span class="rpm-bar-stat-lbl">Avg days w/ reading</span>-->
                                    <!--                <span class="rpm-bar-stat-val" id="bar-avg-days">—</span>-->
                                    <!--            </div>-->
                                    <!--        </div>-->
                                    <!--    </div>-->

                                    <!--</div>-->

                                    {{-- Summary Chips Panel --}}
                                    <!--<div class="rpm-summary-panel">-->
                                    <!--    <div class="rpm-summary-group">-->
                                    <!--        <div class="rpm-summary-label">Avg BP category</div>-->
                                    <!--        <div class="rpm-summary-chips">-->
                                    <!--            <span class="rpm-sum-chip Normal"-->
                                    <!--                onclick="rpmSummaryFilter('category','Normal')">-->
                                    <!--                <span class="rpm-sum-dot"></span>Normal-->
                                    <!--                <strong id="chip-cat-normal">—</strong>-->
                                    <!--            </span>-->
                                    <!--            <span class="rpm-sum-chip Stage-1"-->
                                    <!--                onclick="rpmSummaryFilter('category','Stage-1')">-->
                                    <!--                <span class="rpm-sum-dot"></span>Stage-1-->
                                    <!--                <strong id="chip-cat-s1">—</strong>-->
                                    <!--            </span>-->
                                    <!--            <span class="rpm-sum-chip Stage-2"-->
                                    <!--                onclick="rpmSummaryFilter('category','Stage-2')">-->
                                    <!--                <span class="rpm-sum-dot"></span>Stage-2-->
                                    <!--                <strong id="chip-cat-s2">—</strong>-->
                                    <!--            </span>-->
                                    <!--            <span class="rpm-sum-chip Crisis"-->
                                    <!--                onclick="rpmSummaryFilter('category','Crisis')">-->
                                    <!--                <span class="rpm-sum-dot"></span>Crisis-->
                                    <!--                <strong id="chip-cat-crisis">—</strong>-->
                                    <!--            </span>-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                    <!--    <div class="rpm-summary-divider"></div>-->
                                    <!--    <div class="rpm-summary-group">-->
                                    <!--        <div class="rpm-summary-label">Last BP status</div>-->
                                    <!--        <div class="rpm-summary-chips">-->
                                    <!--            <span class="rpm-sum-chip Normal"-->
                                    <!--                onclick="rpmSummaryFilter('status','Normal')">-->
                                    <!--                <span class="rpm-sum-dot"></span>Normal-->
                                    <!--                <strong id="chip-sta-normal">—</strong>-->
                                    <!--            </span>-->
                                    <!--            <span class="rpm-sum-chip Stage-1"-->
                                    <!--                onclick="rpmSummaryFilter('status','Stage-1')">-->
                                    <!--                <span class="rpm-sum-dot"></span>Stage-1-->
                                    <!--                <strong id="chip-sta-s1">—</strong>-->
                                    <!--            </span>-->
                                    <!--            <span class="rpm-sum-chip Stage-2"-->
                                    <!--                onclick="rpmSummaryFilter('status','Stage-2')">-->
                                    <!--                <span class="rpm-sum-dot"></span>Stage-2-->
                                    <!--                <strong id="chip-sta-s2">—</strong>-->
                                    <!--            </span>-->
                                    <!--            <span class="rpm-sum-chip Crisis"-->
                                    <!--                onclick="rpmSummaryFilter('status','Crisis')">-->
                                    <!--                <span class="rpm-sum-dot"></span>Crisis-->
                                    <!--                <strong id="chip-sta-crisis">—</strong>-->
                                    <!--            </span>-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                    <!--    <div class="rpm-summary-divider"></div>-->
                                    <!--    <div class="rpm-summary-group">-->
                                    <!--        <div class="rpm-summary-label">No reading</div>-->
                                    <!--        <div class="rpm-summary-chips">-->
                                    <!--            <span class="rpm-sum-chip no-data"-->
                                    <!--                onclick="rpmSummaryFilter('nodata','')">-->
                                    <!--                <span class="rpm-sum-dot"></span>No data-->
                                    <!--                <strong id="chip-nodata">—</strong>-->
                                    <!--            </span>-->
                                    <!--            <span class="rpm-sum-chip total">-->
                                    <!--                Total <strong id="chip-total">—</strong>-->
                                    <!--            </span>-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                    <!--</div>-->

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

                                    {{-- Active filter tags --}}
                                    <div class="rpm-active-tags" id="rpm-active-tags"></div>

                                    {{-- Loader overlay --}}
                                    <div id="rpm-loader"
                                        style="display:none; position:absolute; top:0; left:0;
                                                width:100%; height:100%; background:rgba(0,0,0,0.4);
                                                z-index:10; justify-content:center; align-items:center;">
                                        <div class="spinner-border text-primary" style="width:3rem;height:3rem;"
                                            role="status"></div>
                                    </div>

                                    {{-- Table --}}
                                    <div class="table-responsive position-relative" id="rpm_patient_table_wrapper">
                                        <table id="rpm_patient_table"
                                            class="table table-striped table-bordered w-100 nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Patient</th>
                                                    <th>Avg(BP)</th>
                                                    <th data-id="select_category_rpm">Category</th>
                                                    <th>Last BP</th>
                                                    <th data-id="select_status_rpm">Status</th>
                                                    <th>Avg(PR)</th>
                                                    <th>Last PR</th>
                                                    <th data-id="select_time_taken_rpm">Time Taken</th>
                                                    <th data-id="select_last_checked_rpm">Last Checked</th>
                                                    <th data-id="select_minutes_rpm">Minutes(Month)</th>
                                                    <th data-id="select_days_with_reading_rpm">Days With Reading</th>
                                                    <th>Completed Call</th>
                                                    <th>Covid Status</th>
                                                    <th>Provider</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>

                        </div>




                        {{-- unenrolled patients --}}
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
                                    <option value="None" {{ $select_status_rpm == 'None' ? 'selected' : '' }}> --select
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
                                    <option value="None" {{ $select_status_rpm == 'None' ? 'selected' : '' }}> --select
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
                                    <option value="None" {{ $select_status_rpm == 'None' ? 'selected' : '' }}> --Time
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
                                    <option value="None" {{ $select_status_rpm == 'None' ? 'selected' : '' }}> --Last
                                        Checked--</option>
                                    <option value="Min-Max" {{ $select_last_checked_rpm == 'Min-Max' ? 'selected' : '' }}>
                                        Min-Max</option>
                                    <option value="Max-Min" {{ $select_last_checked_rpm == 'Max-Min' ? 'selected' : '' }}>
                                        Max-Min</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label for="">Select Min This Month</label>
                                <select class="form-control" name="select_minutes_rpm" id="select_minutes_rpm">
                                    <option value="None" {{ $select_minutes_rpm == 'None' ? 'selected' : '' }}> --Min
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
                                        {{ $select_days_with_reading_rpm == 'None' ? 'selected' : '' }}>
                                        --Days With
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

    {{-- rpm patients table script code  --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
    <script>
        var rpm_table;
        var _rpmCharts = {};
        var _rpmActiveChip = {
            category: null,
            status: null,
            nodata: false
        };

        // ── Helper: strip HTML for export ────────────────────────────────────────
        function stripHtml(html) {
            return $('<div>').html(html).text().trim();
        }

        // ── Helper: fetch all rows for Excel/Print export ─────────────────────────
        function fetchAllData(url, searchValue, callback) {
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    draw: 1,
                    start: 0,
                    length: -1,
                    'search[value]': searchValue
                },
                success: function(res) {
                    callback(res.data || null);
                },
                error: function() {
                    callback(null);
                }
            });
        }

        // ── Loader helpers ────────────────────────────────────────────────────────
        function rpmShowLoader() {
            $('#rpm-loader').css('display', 'flex');
        }
        function rpmHideLoader() {
            $('#rpm-loader').css('display', 'none');
        }

        $(document).ready(function() {

            // ── DataTable init ────────────────────────────────────────────────────
            rpm_table = $('#rpm_patient_table').DataTable({
                serverSide: true,
                processing: false,
                ajax: {
                    url: '/patients/rpm',
                    type: 'GET',
                    data: function(d) {
                        if (_rpmActiveChip.category) d.filter_category = _rpmActiveChip.category;
                        if (_rpmActiveChip.status)   d.filter_status   = _rpmActiveChip.status;
                        if (_rpmActiveChip.nodata)   d.filter_nodata   = 1;
                    }
                },
                dom: '<lBf<t>ip>',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel"></i> Excel',
                        className: 'btn btn-success btn-sm text-white px-3 py-2',
                        filename: 'RPM-Patients_' + new Date().toISOString().slice(0, 10),
                        title: 'RPM Patients',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            header: true,
                            format: {
                                body: function(data) {
                                    return stripHtml(data);
                                }
                            }
                        },
                        action: function(e, dt, button, config) {
                            var that = this;
                            var $btn = $(button);
                            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Exporting...');
                            fetchAllData('/patients/rpm', dt.search(), function(allData) {
                                if (!allData) {
                                    $btn.prop('disabled', false).html('<i class="fa fa-file-excel"></i> Excel');
                                    return;
                                }
                                var s = dt.settings()[0];
                                var origAjax = s.ajax, origSS = s.oFeatures.bServerSide;
                                s.oFeatures.bServerSide = false;
                                s.ajax = null;
                                dt.clear();
                                dt.rows.add(allData);
                                dt.draw(false);
                                setTimeout(function() {
                                    $.fn.dataTable.ext.buttons.excelHtml5.action.call(that, e, dt, button, config);
                                    s.oFeatures.bServerSide = origSS;
                                    s.ajax = origAjax;
                                    dt.ajax.reload(null, false);
                                    $btn.prop('disabled', false).html('<i class="fa fa-file-excel"></i> Excel');
                                }, 100);
                            });
                        },
                        customizeData: function(data) {
                            var h = ['#', 'Patient', 'Avg(BP)', 'Category', 'Last BP', 'Status',
                                'Avg(PR)', 'Last PR', 'Time Taken', 'Last Checked',
                                'Minutes(Month)', 'Days With Reading', 'Completed Call',
                                'Covid Status', 'Provider'];
                            if (data.body.length > 0 && h.length === data.body[0].length) data.header = h;
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i> Print',
                        className: 'btn btn-primary btn-sm text-white px-3 py-2',
                        title: 'RPM Patients',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            stripHtml: false,
                            header: true
                        },
                        action: function(e, dt, button, config) {
                            var that = this;
                            var $btn = $(button);
                            $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                            fetchAllData('/patients/rpm', dt.search(), function(allData) {
                                if (!allData) {
                                    $btn.prop('disabled', false).html('<i class="fa fa-print"></i> Print');
                                    return;
                                }
                                var s = dt.settings()[0];
                                var origAjax = s.ajax, origSS = s.oFeatures.bServerSide;
                                s.oFeatures.bServerSide = false;
                                s.ajax = null;
                                dt.clear();
                                dt.rows.add(allData);
                                dt.draw(false);
                                setTimeout(function() {
                                    $.fn.dataTable.ext.buttons.print.action.call(that, e, dt, button, config);
                                    s.oFeatures.bServerSide = origSS;
                                    s.ajax = origAjax;
                                    dt.ajax.reload(null, false);
                                    $btn.prop('disabled', false).html('<i class="fa fa-print"></i> Print');
                                }, 500);
                            });
                        },
                        customize: function(win) {
                            var h = ['#', 'Patient', 'Avg(BP)', 'Category', 'Last BP', 'Status',
                                'Avg(PR)', 'Last PR', 'Time Taken', 'Last Checked',
                                'Minutes(Month)', 'Days With Reading', 'Completed Call',
                                'Covid Status', 'Provider'];
                            var ths = $(win.document).find('thead th');
                            if (ths.length === h.length) ths.each(function(i) { $(this).text(h[i]); });
                            $(win.document.body).find('table').addClass('table table-bordered');
                            $(win.document.body).find('h1').css({ textAlign: 'center', fontSize: '18px' });
                        }
                    }
                ],
                responsive: true,
                pageLength: 100,
                order: [[8, 'asc']],
                columnDefs: [
                    { targets: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11], className: 'text-nowrap' },
                    { targets: [0],    width: '50px'  },
                    { targets: [2, 6], width: '80px'  },
                    { targets: [5],    width: '100px' },
                ],
                language: {
                    processing: ''
                },
                initComplete: function() {
                    rpmWireProviderSelect(this.api());
                    rpmWireFilterSelects();
                }
            });

            // ── Loader events ─────────────────────────────────────────────────────
            rpm_table.on('preXhr.dt', rpmShowLoader);
            rpm_table.on('xhr.dt',    rpmHideLoader);
            rpm_table.on('error.dt',  rpmHideLoader);

            // ── Count badge ───────────────────────────────────────────────────────
            rpm_table.on('draw', function() {
                var info = rpm_table.page.info();
                var text = info.recordsDisplay < info.recordsTotal
                    ? info.recordsDisplay + ' / ' + info.recordsTotal
                    : info.recordsTotal;
                $('#rpm-count-num').text(text);
                rpmUpdateLastUpdated();
            });

            // ── Wire 6 filter-bar selects ─────────────────────────────────────────
            function rpmWireFilterSelects() {
                var map = [
                    { id: 'select_category_rpm',          col: 3  },
                    { id: 'select_status_rpm',            col: 5  },
                    { id: 'select_time_taken_rpm',        col: 8  },
                    { id: 'select_last_checked_rpm',      col: 9  },
                    { id: 'select_minutes_rpm',           col: 10 },
                    { id: 'select_days_with_reading_rpm', col: 11 },
                ];
                map.forEach(function(m) {
                    $('#' + m.id).off('change').on('change', function() {
                        rpmShowLoader();
                        var val = $(this).val();
                        if (val === 'None') {
                            rpm_table.order([8, 'asc']).draw();
                        } else {
                            rpm_table.order([m.col, val === 'Min-Max' ? 'asc' : 'desc']).draw();
                        }
                        rpmSyncActiveFilterTags();
                    });
                });
            }

            // ── Active sort tag strip ─────────────────────────────────────────────
            function rpmSyncActiveFilterTags() {
                var labels = {
                    select_category_rpm:          'Category',
                    select_status_rpm:            'Status',
                    select_time_taken_rpm:        'Time taken',
                    select_last_checked_rpm:      'Last checked',
                    select_minutes_rpm:           'Minutes',
                    select_days_with_reading_rpm: 'Days',
                };
                var $strip = $('#rpm-active-tags').empty();

                // Sort tags
                Object.keys(labels).forEach(function(id) {
                    var val = $('#' + id).val();
                    if (!val || val === 'None') return;
                    $strip.append(
                        $('<span>').text(labels[id] + (val === 'Min-Max' ? ' ↑' : ' ↓'))
                            .css({
                                display: 'inline-flex', alignItems: 'center',
                                fontSize: '11px', padding: '2px 8px',
                                borderRadius: '20px', marginRight: '6px',
                                background: 'rgba(59,130,246,.15)',
                                color: '#3b82f6', cursor: 'pointer'
                            })
                            .on('click', function() {
                                $('#' + id).val('None').trigger('change');
                            })
                    );
                });

                // Chip filter tags
                if (_rpmActiveChip.category) {
                    $strip.append(rpmChipTag('Category: ' + _rpmActiveChip.category, function() {
                        _rpmActiveChip.category = null;
                        rpmSyncChipHighlights();
                        rpmShowLoader();
                        rpm_table.ajax.reload();
                        rpmSyncActiveFilterTags();
                    }));
                }
                if (_rpmActiveChip.status) {
                    $strip.append(rpmChipTag('Status: ' + _rpmActiveChip.status, function() {
                        _rpmActiveChip.status = null;
                        rpmSyncChipHighlights();
                        rpmShowLoader();
                        rpm_table.ajax.reload();
                        rpmSyncActiveFilterTags();
                    }));
                }
                if (_rpmActiveChip.nodata) {
                    $strip.append(rpmChipTag('No data', function() {
                        _rpmActiveChip.nodata = false;
                        rpmSyncChipHighlights();
                        rpmShowLoader();
                        rpm_table.ajax.reload();
                        rpmSyncActiveFilterTags();
                    }));
                }
            }

            function rpmChipTag(label, onRemove) {
                return $('<span>').text('✕ ' + label)
                    .css({
                        display: 'inline-flex', alignItems: 'center',
                        fontSize: '11px', padding: '2px 8px',
                        borderRadius: '20px', marginRight: '6px',
                        background: 'rgba(239,68,68,.15)',
                        color: '#ef4444', cursor: 'pointer'
                    })
                    .on('click', onRemove);
            }

            // ── Provider select (column 14) ───────────────────────────────────────
            function rpmWireProviderSelect(api) {
                $('#select_care_manager_rpm').empty();
                var select = $('<select class="form-control form-control-sm"><option value="">All providers</option></select>')
                    .appendTo('#select_care_manager_rpm')
                    .on('change', function() {
                        rpmShowLoader();
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        api.column(14).search(val ? '^' + val + '$' : '', true, false).draw();
                    });
                api.column(14).data().unique().sort().each(function(d) {
                    var val = $('<div>').html(d).text().trim();
                    if (val) select.append('<option value="' + val + '">' + val + '</option>');
                });
            }

            // ── Manual refresh ────────────────────────────────────────────────────
            $('#rpm-manual-refresh').on('click', function() {
                rpmShowLoader();
                rpmSpinRefreshIcon(true);
                rpmLoadStats();
                rpm_table.ajax.reload(function() {
                    rpmSpinRefreshIcon(false);
                }, false);
            });

            // ── Load stats ────────────────────────────────────────────────────────
            function rpmLoadStats() {
                $.ajax({
                    url: '/patients/rpm/stats',
                    type: 'GET',
                    success: function(s) { rpmApplyStats(s); },
                    error: function() { console.warn('RPM stats load failed'); }
                });
            }

            // ── Apply stats to KPIs, charts, chips ────────────────────────────────
            function rpmApplyStats(s) {
                var total = s.total || 0;

                // KPI cards
                $('#kpi-total').text(total);
                $('#kpi-crisis').text(s.summaryCrisis);
                $('#kpi-crisis-sub')
                    .text(s.summaryCrisis > 0 ? 'Needs attention' : 'All clear')
                    .toggleClass('rpm-kpi-warn', s.summaryCrisis > 0);
                $('#kpi-crisis-bar').css('--w', (total > 0 ? Math.round((s.summaryCrisis / total) * 100) : 0) + '%');
                $('#kpi-calls').text(s.callsDone);
                $('#kpi-calls-sub').text((total > 0 ? Math.round((s.callsDone / total) * 100) : 0) + '% completion');
                $('#kpi-calls-bar').css('--w', (total > 0 ? Math.round((s.callsDone / total) * 100) : 0) + '%');
                $('#kpi-nodata').text(s.noData);
                $('#kpi-nodata-bar').css('--w', (total > 0 ? Math.round((s.noData / total) * 100) : 0) + '%');

                // Donut centers
                $('#donut-withdata-avg').text(s.withData);
                $('#donut-withdata-last').text(s.withData);
                $('#donut-totalmins').text(s.totalMins);

                // Legend counts
                $('#leg-avg-normal').text(s.summaryNormal);
                $('#leg-avg-s1').text(s.summaryS1);
                $('#leg-avg-s2').text(s.summaryS2);
                $('#leg-avg-crisis').text(s.summaryCrisis);
                $('#leg-last-normal').text(s.statusNormal);
                $('#leg-last-s1').text(s.statusS1);
                $('#leg-last-s2').text(s.statusS2);
                $('#leg-last-crisis').text(s.statusCrisis);
                $('#leg-mins-above').text(s.aboveGoal);
                $('#leg-mins-near').text(s.nearGoal);
                $('#leg-mins-below').text(s.belowGoal);
                $('#leg-mins-none').text(s.noMins);

                // Chips
                $('#chip-cat-normal').text(s.summaryNormal);
                $('#chip-cat-s1').text(s.summaryS1);
                $('#chip-cat-s2').text(s.summaryS2);
                $('#chip-cat-crisis').text(s.summaryCrisis);
                $('#chip-sta-normal').text(s.statusNormal);
                $('#chip-sta-s1').text(s.statusS1);
                $('#chip-sta-s2').text(s.statusS2);
                $('#chip-sta-crisis').text(s.statusCrisis);
                $('#chip-nodata').text(s.noData);
                $('#chip-total').text(total);

                // Bar stats
                var totalSecs = s.perPatient && s.perPatient.length > 0
                    ? s.perPatient.reduce(function(acc, p) { return acc + (p.mins * 60); }, 0) : 0;
                var avgSecs = total > 0 ? Math.round(totalSecs / total) : 0;
                var avgM    = Math.floor(avgSecs / 60);
                var avgS    = avgSecs % 60;
                $('#bar-avg-per-patient').text(avgM + 'm ' + avgS + 's');
                $('#bar-below-target')
                    .text((total - s.aboveGoal) + ' below target')
                    .toggleClass('rpm-kpi-warn', avgM < 20);
                $('#bar-avg-days').text(s.avgDays + ' days');

                rpmRebuildCharts(s);
            }

            // ── Charts ────────────────────────────────────────────────────────────
            function rpmRebuildCharts(s) {
                var C_NORMAL = '#34c787', C_S1 = '#f6c94e', C_S2 = '#f49b35',
                    C_CRISIS = '#fb1031', C_NONE = 'rgba(255,255,255,.08)';

                var DONUT = {
                    cutout: '72%',
                    plugins: { legend: { display: false }, tooltip: { enabled: false } },
                    animation: { animateRotate: true, duration: 700 },
                };

                function rebuild(id, data, colors) {
                    if (_rpmCharts[id]) { _rpmCharts[id].destroy(); delete _rpmCharts[id]; }
                    var ctx = document.getElementById(id);
                    if (!ctx) return;
                    _rpmCharts[id] = new Chart(ctx, {
                        type: 'doughnut',
                        data: { datasets: [{ data: data, backgroundColor: colors,
                                             borderWidth: 0, spacing: 2, borderRadius: 3 }] },
                        options: DONUT,
                    });
                }

                rebuild('rpmAvgBpChart',
                    [s.summaryNormal, s.summaryS1, s.summaryS2, s.summaryCrisis, Math.max(0, s.noData)],
                    [C_NORMAL, C_S1, C_S2, C_CRISIS, C_NONE]);

                rebuild('rpmLastBpChart',
                    [s.statusNormal, s.statusS1, s.statusS2, s.statusCrisis, Math.max(0, s.noData)],
                    [C_NORMAL, C_S1, C_S2, C_CRISIS, C_NONE]);

                rebuild('rpmMinsChart',
                    [s.aboveGoal, s.nearGoal, s.belowGoal, Math.max(0, s.noMins)],
                    [C_NORMAL, C_S1, C_S2, C_NONE]);

                if (_rpmCharts['rpmPerPatientChart']) {
                    _rpmCharts['rpmPerPatientChart'].destroy();
                    delete _rpmCharts['rpmPerPatientChart'];
                }
                var barCtx = document.getElementById('rpmPerPatientChart');
                if (barCtx && s.perPatient && s.perPatient.length) {
                    var mins    = s.perPatient.map(function(p) { return p.mins; });
                    var colours = mins.map(function(m) {
                        return m >= 20 ? C_NORMAL : m >= 12 ? C_S1 : C_S2;
                    });
                    _rpmCharts['rpmPerPatientChart'] = new Chart(barCtx, {
                        type: 'bar',
                        data: { datasets: [{ data: mins, backgroundColor: colours,
                                             borderRadius: 3, borderWidth: 0 }] },
                        options: {
                            responsive: true, maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                tooltip: { callbacks: { label: function(c) { return c.parsed.y + ' min'; } } }
                            },
                            scales: {
                                x: { ticks: { color: 'rgba(255,255,255,.45)', font: { size: 9 }, maxRotation: 0 },
                                     grid: { display: false }, border: { display: false } },
                                y: { ticks: { color: 'rgba(255,255,255,.35)', font: { size: 9 },
                                              callback: function(v) { return v + 'm'; }, stepSize: 10 },
                                     grid: { color: 'rgba(255,255,255,.05)' }, border: { display: false },
                                     suggestedMax: 30 }
                            }
                        }
                    });
                }
            }

            // ── Summary chip → server-side filter ─────────────────────────────────
            window.rpmSummaryFilter = function(type, value) {
                rpmShowLoader();
                if (type === 'category') {
                    _rpmActiveChip.category = (_rpmActiveChip.category === value) ? null : value;
                } else if (type === 'status') {
                    _rpmActiveChip.status = (_rpmActiveChip.status === value) ? null : value;
                } else if (type === 'nodata') {
                    _rpmActiveChip.nodata = !_rpmActiveChip.nodata;
                }
                rpmSyncChipHighlights();
                rpmSyncActiveFilterTags();
                rpm_table.ajax.reload();
                document.getElementById('rpm_patient_table_wrapper')
                    .scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            };

            function rpmSyncChipHighlights() {
                $('.rpm-sum-chip.Normal, .rpm-sum-chip.Stage-1, .rpm-sum-chip.Stage-2, .rpm-sum-chip.Crisis')
                    .css('opacity', '1');
                if (_rpmActiveChip.category) {
                    $('.rpm-summary-group').first().find('.rpm-sum-chip')
                        .not('.' + _rpmActiveChip.category)
                        .css('opacity', '0.4');
                }
                if (_rpmActiveChip.status) {
                    $('.rpm-summary-group').eq(1).find('.rpm-sum-chip')
                        .not('.' + _rpmActiveChip.status)
                        .css('opacity', '0.4');
                }
            }

            // ── Last-updated helpers ──────────────────────────────────────────────
            var _rpmLastUpdatedDate = null;
            var _rpmRelativeTimer   = null;

            function rpmUpdateLastUpdated() { rpmSetLastUpdated(new Date()); }
            function rpmSetLastUpdated(date) {
                _rpmLastUpdatedDate = date;
                rpmRenderRelative();
                clearInterval(_rpmRelativeTimer);
                _rpmRelativeTimer = setInterval(rpmRenderRelative, 30000);
            }
            function rpmRenderRelative() {
                if (!_rpmLastUpdatedDate) return;
                var diff = Math.floor((Date.now() - _rpmLastUpdatedDate.getTime()) / 1000);
                var text = diff < 60    ? 'just now'
                         : diff < 3600  ? Math.floor(diff / 60)   + ' min ago'
                         : diff < 86400 ? Math.floor(diff / 3600)  + ' hr ago'
                         :                Math.floor(diff / 86400) + ' d ago';
                $('#rpm-last-updated-text').text(text);
            }
            function rpmSpinRefreshIcon(on) {
                var btn = $('#rpm-manual-refresh');
                if (on) btn.addClass('spinning').prop('disabled', true);
                else    btn.removeClass('spinning').prop('disabled', false);
            }

            // ── Auto-reload every 10 minutes ──────────────────────────────────────
            setInterval(function() {
                rpmLoadStats();
                rpm_table.ajax.reload(null, false);
            }, 600000);

            // ── Initial stats load ────────────────────────────────────────────────
            rpmLoadStats();

        }); // end document.ready
    </script>



    {{-- ccm and unenrolled tables script code --}}
    <script>
        $(document).ready(function() {

            // Handle URL hash for correct tab on load
            if (window.location.hash) {
                var hash = window.location.hash.substring(1);
                if (hash === "rpm") {
                    $('#rpm_link').trigger('click');
                } else if (hash === "unenrolled") {
                    $('#unenrolled_link').trigger('click');
                } else {
                    $('#ccm_link').trigger('click');
                }
            }

            // Helper function to fetch all data in chunks
            function fetchAllData(url, searchValue, callback) {
                var allData = [];
                var start = 0;
                var length = 1000; // Fetch 1000 records at a time

                function fetchChunk() {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        data: {
                            draw: 1,
                            start: start,
                            length: length,
                            search: {
                                value: searchValue
                            }
                        },
                        success: function(json) {
                            allData = allData.concat(json.data);

                            // Check if there are more records
                            if (json.data.length === length && allData.length < json.recordsFiltered) {
                                start += length;
                                fetchChunk(); // Fetch next chunk
                            } else {
                                // All data fetched
                                callback(allData);
                            }
                        },
                        error: function() {
                            alert('Error fetching data for export');
                            callback(null);
                        }
                    });
                }

                fetchChunk();
            }

            // Helper function to strip HTML tags safely
            function stripHtml(html) {
                if (!html) return '';
                var tmp = document.createElement("DIV");
                tmp.innerHTML = html;
                return tmp.textContent || tmp.innerText || "";
            }

            // CCM Table - Server Side
            var ccm_table = $('#ccm_patient_table').DataTable({
                serverSide: true,
                processing: true,
                ajax: '/patients/ccm',
                dom: '<lBf<t>ip>',
                buttons: [{
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel"></i> Excel',
                        className: 'btn btn-success btn-sm text-white px-3 py-2',
                        filename: 'CCM-Patients_' + new Date().toISOString().slice(0, 10),
                        title: 'CCM Patients',
                        exportOptions: {
                            columns: ':not(:last-child)', // This includes hidden columns but excludes action column
                            header: true,
                            format: {
                                body: function(data, row, column, node) {
                                    return stripHtml(data);
                                }
                            }
                        },
                        action: function(e, dt, button, config) {
                            var that = this;
                            var $button = $(button);
                            $button.prop('disabled', true).html(
                                '<i class="fa fa-spinner fa-spin"></i> Exporting...');
                            var searchValue = dt.search();

                            fetchAllData('/patients/ccm', searchValue, function(allData) {
                                if (!allData) {
                                    $button.prop('disabled', false).html(
                                        '<i class="fa fa-file-excel"></i> Excel');
                                    return;
                                }
                                var originalAjax = dt.settings()[0].ajax;
                                var originalServerSide = dt.settings()[0].oFeatures
                                    .bServerSide;
                                dt.settings()[0].oFeatures.bServerSide = false;
                                dt.settings()[0].ajax = null;
                                dt.clear();
                                dt.rows.add(allData);
                                dt.draw(false);

                                setTimeout(function() {
                                    $.fn.dataTable.ext.buttons.excelHtml5.action
                                        .call(that, e, dt, button, config);
                                    dt.settings()[0].oFeatures.bServerSide =
                                        originalServerSide;
                                    dt.settings()[0].ajax = originalAjax;
                                    dt.ajax.reload(null, false);
                                    $button.prop('disabled', false).html(
                                        '<i class="fa fa-file-excel"></i> Excel'
                                    );
                                }, 100);
                            });
                        },
                        customizeData: function(data) {
                            // 1. Manually set the header
                            var newHeader = ['#', 'Patient Name', 'Covid Status', 'Gender', 'DOB',
                                'Contact No', 'Email', 'Enrol Date', 'Care Manager',
                                'Care Plan Created', 'Last CCM Performed', 'Address'
                            ];

                            // Safety Check: Ensure header length matches body length to prevent corruption
                            if (data.body.length > 0 && newHeader.length === data.body[0].length) {
                                data.header = newHeader;
                            }

                            // 2. Format Body Data
                            const nameColIndex = 1;
                            const dobColIndex = 4;
                            const enrolDateColIndex = 7;
                            const carePlanDateColIndex = 9;
                            const lastCcmDateColIndex = 10;

                            // Helper for dates inside the loop
                            function formatDate(dateStr) {
                                if (!dateStr || dateStr === "-" || dateStr === "N/A")
                                    return dateStr;
                                const d = new Date(dateStr);
                                if (isNaN(d.getTime())) return dateStr;
                                return d.toLocaleDateString("en-US", {
                                    year: 'numeric',
                                    month: '2-digit',
                                    day: '2-digit'
                                });
                            }

                            data.body.forEach(function(row) {
                                // Fix Name (Last, First)
                                if (row[nameColIndex]) {
                                    const parts = row[nameColIndex].trim().split(" ");
                                    if (parts.length >= 2) {
                                        row[nameColIndex] = parts[parts.length - 1] + ", " +
                                            parts.slice(0, -1).join(" ");
                                    }
                                }
                                // Fix Dates
                                row[dobColIndex] = formatDate(row[dobColIndex]);
                                row[enrolDateColIndex] = formatDate(row[enrolDateColIndex]);
                                row[carePlanDateColIndex] = formatDate(row[
                                    carePlanDateColIndex]);
                                row[lastCcmDateColIndex] = formatDate(row[
                                    lastCcmDateColIndex]);
                            });
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i> Print',
                        className: 'btn btn-primary btn-sm text-white px-3 py-2',
                        title: 'CCM Patients',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            stripHtml: false, // Often better for print to keep some formatting
                            header: true
                        },
                        action: function(e, dt, button, config) {
                            var that = this;
                            var $button = $(button);
                            $button.prop('disabled', true).html(
                                '<i class="fa fa-spinner fa-spin"></i> Loading...');
                            var searchValue = dt.search();

                            fetchAllData('/patients/ccm', searchValue, function(allData) {
                                if (!allData) {
                                    $button.prop('disabled', false).html(
                                        '<i class="fa fa-print"></i> Print');
                                    return;
                                }
                                var originalAjax = dt.settings()[0].ajax;
                                var originalServerSide = dt.settings()[0].oFeatures
                                    .bServerSide;
                                dt.settings()[0].oFeatures.bServerSide = false;
                                dt.settings()[0].ajax = null;
                                dt.clear();
                                dt.rows.add(allData);
                                dt.draw(false);

                                setTimeout(function() {
                                        $.fn.dataTable.ext.buttons.print.action.call(
                                            that, e, dt, button, config);
                                        dt.settings()[0].oFeatures.bServerSide =
                                            originalServerSide;
                                        dt.settings()[0].ajax = originalAjax;
                                        dt.ajax.reload(null, false);
                                        $button.prop('disabled', false).html(
                                            '<i class="fa fa-print"></i> Print');
                                    },
                                    500
                                ); // Increased timeout to ensure DOM renders before print dialog
                            });
                        },
                        // CUSTOMIZE DATA DOES NOT WORK FOR PRINT. USE THIS INSTEAD:
                        customize: function(win) {
                            var doc = win.document;

                            // Manual Header Injection if missing (Print takes a snapshot of DOM)
                            var headers = ['#', 'Patient Name', 'Covid Status', 'Gender', 'DOB',
                                'Contact No', 'Email', 'Enrol Date', 'Care Manager',
                                'Care Plan Created', 'Last CCM Performed', 'Address'
                            ];

                            // Find the table header in the print window
                            var tHead = $(doc).find('thead');

                            // Ideally, the 'dt.draw(false)' in the action should have rendered the header.
                            // But if you need to force change the text:
                            if (tHead.length > 0) {
                                var ths = tHead.find('th');
                                if (ths.length === headers.length) {
                                    ths.each(function(index) {
                                        $(this).text(headers[index]);
                                    });
                                }
                            }

                            // Optional: Styling for print
                            $(doc.body).find('table').addClass('table table-bordered');
                            $(doc.body).find('h1').css('text-align', 'center').css('font-size',
                                '18px');
                        }
                    }
                    /* Commented out Current Page buttons
                    ,{
                        extend: 'excel',
                        text: '<i class="fa fa-file-excel"></i> Current Page',
                        className: 'btn btn-outline-success btn-sm text-white px-3 py-2',
                        filename: 'CCM-Patients_' + new Date().toISOString().slice(0,10),
                        title: 'CCM Patients',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            format: {
                                header: function(data, columnIdx) {
                                    var headers = ['#', 'Patient Name', 'Covid Status', 'Gender', 'DOB', 'Contact No', 'Email', 'Enrol Date', 'Care Manager', 'Care Plan Created', 'Last CCM Performed', 'Address'];
                                    return headers[columnIdx] || data;
                                }
                            }
                        },
                        customizeData: function(data) {
                            const nameColIndex = 1;
                            const dobColIndex = 4;
                            const enrolDateColIndex = 7;
                            const carePlanDateColIndex = 9;
                            const lastCcmDateColIndex = 10;

                            data.body.forEach(function(row) {
                                // Name reorder
                                const nameCell = row[nameColIndex];
                                const parts = nameCell.trim().split(" ");
                                if (parts.length >= 2) {
                                    const firstName = parts.slice(0, -1).join(" ");
                                    const lastName = parts[parts.length - 1];
                                    row[nameColIndex] = `${lastName}, ${firstName}`;
                                }

                                // Date formatting
                                function formatDate(dateStr) {
                                    if (!dateStr || dateStr === "-" || dateStr === "N/A")
                                        return dateStr;
                                    const d = new Date(dateStr);
                                    if (isNaN(d.getTime())) return dateStr;
                                    const mm = String(d.getMonth() + 1).padStart(2, "0");
                                    const dd = String(d.getDate()).padStart(2, "0");
                                    const yyyy = d.getFullYear();
                                    return `${mm}/${dd}/${yyyy}`;
                                }

                                row[dobColIndex] = formatDate(row[dobColIndex]);
                                row[enrolDateColIndex] = formatDate(row[enrolDateColIndex]);
                                row[carePlanDateColIndex] = formatDate(row[carePlanDateColIndex]);
                                row[lastCcmDateColIndex] = formatDate(row[lastCcmDateColIndex]);
                            });
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i> Current Page',
                        className: 'btn btn-outline-secondary btn-sm text-white px-3 py-2',
                        title: 'CCM Patients',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            format: {
                                header: function(data, columnIdx) {
                                    var headers = ['#', 'Patient Name', 'Covid Status', 'Gender', 'DOB', 'Contact No', 'Email', 'Enrol Date', 'Care Manager', 'Care Plan Created', 'Last CCM Performed', 'Address'];
                                    return headers[columnIdx] || data;
                                }
                            }
                        }
                    }
                    */
                ],
                responsive: true,
                pageLength: 25,
                order: [
                    [0, 'asc']
                ],
                columnDefs: [{
                    targets: [4, 6, 11],
                    visible: false
                }],
                initComplete: function() {
                    this.api().columns(8).every(function() {
                        var column = this;
                        var select = $(
                                '<select class="form-control form-control-sm"><option value="">All Care Managers</option></select>'
                            )
                            .appendTo('#select_care_manager_ccm')
                            .on('change', function() {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                column.search(val ? '^' + val + '$' : '', true, false)
                                    .draw();
                            });

                        column.data().unique().sort().each(function(d) {
                            var val = $('<div>').html(d).text().trim();
                            if (val) {
                                select.append('<option value="' + val + '">' + val +
                                    '</option>');
                            }
                        });
                    });
                }
            });
            // CCM Table - Server Side code ends here



            // Unenrolled Table - Server Side
            var unenrolled_table = $('#unenrolled_patient_table').DataTable({
                serverSide: true,
                processing: true,
                ajax: '/patients/unenrolled',
                dom: '<lBf<t>ip>',
                buttons: [{
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel"></i> Excel',
                        className: 'btn btn-success btn-sm text-white px-3 py-2',
                        filename: 'Unenrolled-Patients_' + new Date().toISOString().slice(0, 10),
                        title: 'Unenrolled Patients',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            header: true,
                            format: {
                                body: function(data, row, column, node) {
                                    return stripHtml(data);
                                }
                            }
                        },
                        action: function(e, dt, button, config) {
                            var that = this;
                            var $button = $(button);
                            $button.prop('disabled', true).html(
                                '<i class="fa fa-spinner fa-spin"></i> Exporting...');
                            var searchValue = dt.search();

                            fetchAllData('/patients/unenrolled', searchValue, function(allData) {
                                if (!allData) {
                                    $button.prop('disabled', false).html(
                                        '<i class="fa fa-file-excel"></i> Excel');
                                    return;
                                }
                                var originalAjax = dt.settings()[0].ajax;
                                var originalServerSide = dt.settings()[0].oFeatures
                                    .bServerSide;
                                dt.settings()[0].oFeatures.bServerSide = false;
                                dt.settings()[0].ajax = null;
                                dt.clear();
                                dt.rows.add(allData);
                                dt.draw(false);

                                setTimeout(function() {
                                    $.fn.dataTable.ext.buttons.excelHtml5.action
                                        .call(that, e, dt, button, config);
                                    dt.settings()[0].oFeatures.bServerSide =
                                        originalServerSide;
                                    dt.settings()[0].ajax = originalAjax;
                                    dt.ajax.reload(null, false);
                                    $button.prop('disabled', false).html(
                                        '<i class="fa fa-file-excel"></i> Excel'
                                    );
                                }, 100);
                            });
                        },
                        customizeData: function(data) {
                            var newHeader = ['#', 'Patient Name', 'Gender', 'Contact no', 'Address',
                                'Un-Enroll Note'
                            ];

                            if (data.body.length > 0 && newHeader.length === data.body[0].length) {
                                data.header = newHeader;
                            }
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i> Print',
                        className: 'btn btn-primary btn-sm text-white px-3 py-2',
                        title: 'Unenrolled Patients',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            stripHtml: false,
                            header: true
                        },
                        action: function(e, dt, button, config) {
                            var that = this;
                            var $button = $(button);
                            $button.prop('disabled', true).html(
                                '<i class="fa fa-spinner fa-spin"></i> Loading...');
                            var searchValue = dt.search();

                            fetchAllData('/patients/unenrolled', searchValue, function(allData) {
                                if (!allData) {
                                    $button.prop('disabled', false).html(
                                        '<i class="fa fa-print"></i> Print');
                                    return;
                                }
                                var originalAjax = dt.settings()[0].ajax;
                                var originalServerSide = dt.settings()[0].oFeatures
                                    .bServerSide;
                                dt.settings()[0].oFeatures.bServerSide = false;
                                dt.settings()[0].ajax = null;
                                dt.clear();
                                dt.rows.add(allData);
                                dt.draw(false);

                                setTimeout(function() {
                                    $.fn.dataTable.ext.buttons.print.action.call(
                                        that, e, dt, button, config);
                                    dt.settings()[0].oFeatures.bServerSide =
                                        originalServerSide;
                                    dt.settings()[0].ajax = originalAjax;
                                    dt.ajax.reload(null, false);
                                    $button.prop('disabled', false).html(
                                        '<i class="fa fa-print"></i> Print');
                                }, 500);
                            });
                        },
                        customize: function(win) {
                            var doc = win.document;
                            var headers = ['#', 'Patient Name', 'Gender', 'Contact no', 'Address',
                                'Un-Enroll Note'
                            ];
                            var tHead = $(doc).find('thead');

                            if (tHead.length > 0) {
                                var ths = tHead.find('th');
                                if (ths.length === headers.length) {
                                    ths.each(function(index) {
                                        $(this).text(headers[index]);
                                    });
                                }
                            }

                            $(doc.body).find('table').addClass('table table-bordered');
                            $(doc.body).find('h1').css('text-align', 'center').css('font-size',
                                '18px');
                        }
                    }
                    /* Commented out Current Page buttons
                    ,{
                        extend: 'excel',
                        text: '<i class="fa fa-file-excel"></i> Current Page',
                        className: 'btn btn-outline-success btn-sm text-white px-3 py-2',
                        filename: 'Unenrolled-Patients_' + new Date().toISOString().slice(0,10),
                        title: 'Unenrolled Patients',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            format: {
                                header: function(data, columnIdx) {
                                    var headers = ['#', 'Patient Name', 'Gender', 'Contact no', 'Address', 'Un-Enroll Note'];
                                    return headers[columnIdx] || data;
                                }
                            }
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print"></i> Current Page',
                        className: 'btn btn-outline-secondary btn-sm text-white px-3 py-2',
                        title: 'Unenrolled Patients',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            format: {
                                header: function(data, columnIdx) {
                                    var headers = ['#', 'Patient Name', 'Gender', 'Contact no', 'Address', 'Un-Enroll Note'];
                                    return headers[columnIdx] || data;
                                }
                            }
                        }
                    }
                    */
                ],
                responsive: true,
                pageLength: 25,
                order: [
                    [0, 'asc']
                ]
            });

            // Restore saved filters
            @if ($select_covid_status_ccm !== 'None')
                $('#select_covid_status_ccm').val('{{ $select_covid_status_ccm }}');
                filter_select_covid_status_ccm('{{ $select_covid_status_ccm }}');
            @endif

            @if ($select_gender_ccm !== 'None')
                $('#select_gender_ccm').val('{{ $select_gender_ccm }}');
                filter_select_gender_ccm('{{ $select_gender_ccm }}');
            @endif

            @if ($select_last_ccm_performed !== 'None')
                $('#select_last_ccm_performed').val('{{ $select_last_ccm_performed }}');
                filter_select_last_ccm_performed('{{ $select_last_ccm_performed }}');
            @endif

            // Tab activation
            $('#ccm_link, #rpm_link, #unenrolled_link').click(function() {
                var tab = $(this).attr('id').replace('_link', '');
                active_tab(tab, true);
            });

            function active_tab(key, value) {
                $.post("{{ route('custom.sort') }}", {
                    key: key,
                    value: value,
                    type: "tab",
                    _token: '{{ csrf_token() }}'
                });
            }

            // Adjust columns when tab changes
            $('a[data-toggle="tab"]').on('shown.bs.tab', function() {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust()
                    .responsive.recalc();
            });

            // Fixed: Last CCM Performed filter
            $('#select_last_ccm_performed').on('change', function() {
                var value = $(this).val();
                sort('select_last_ccm_performed', value, 'ccm');
                filter_select_last_ccm_performed(value);
            });

            function filter_select_last_ccm_performed(search) {
                var date = new Date();
                var month = date.getMonth() + 1;
                var day = date.getDate();

                if (search === "Yesterday") day -= 1;
                if (day < 1) {
                    day = new Date(date.getFullYear(), date.getMonth(), 0).getDate();
                    month -= 1;
                    if (month < 1) month = 12;
                }
                day = day < 10 ? "0" + day : day;
                month = month < 10 ? "0" + month : month;

                var pattern = "";
                if (search === "Today") pattern = month + "-" + day;
                else if (search === "Yesterday") pattern = month + "-" + day;
                else if (search === "This-Month") pattern = "^" + month + "-";
                else if (search === "Prev-Month") {
                    var prev = month - 1 || 12;
                    prev = prev < 10 ? "0" + prev : prev;
                    pattern = "^" + prev + "-";
                }

                ccm_table.column(10).search(pattern, true, false).draw();
            }

            // Gender & Covid filters
            $('#select_gender_ccm').on('change', function() {
                var val = $(this).val();
                sort('select_gender_ccm', val, 'ccm');
                ccm_table.column(3).search(val ? '(^' + val + '$)' : '', true, false).draw();
            });

            $('#select_covid_status_ccm').on('change', function() {
                var val = $(this).val();
                sort('select_covid_status_ccm', val, 'ccm');
                ccm_table.column(2).search(val ? '(^' + val + '$)' : '', true, false).draw();
            });

            // RPM sorting filters (Min-Max etc.)
            $('#select_category_rpm, #select_status_rpm, #select_time_taken_rpm, #select_last_checked_rpm, #select_minutes_rpm, #select_days_with_reading_rpm')
                .change(function() {
                    var id = $(this).attr('id');
                    var value = $(this).val();
                    sort(id, value, 'rpm');

                    var colMap = {
                        select_category_rpm: 3,
                        select_status_rpm: 5,
                        select_time_taken_rpm: 8,
                        select_last_checked_rpm: 9,
                        select_minutes_rpm: 10,
                        select_days_with_reading_rpm: 11
                    };

                    var col = colMap[id];
                    if (value === "Min-Max") rpm_table.order([col, 'asc']).draw();
                    else if (value === "Max-Min") rpm_table.order([col, 'desc']).draw();
                    else rpm_table.order([1, 'asc']).draw();
                });

            function sort(key, value, type) {
                $.post("{{ route('custom.sort') }}", {
                    key: key,
                    value: value,
                    type: type,
                    _token: '{{ csrf_token() }}'
                });
            }
        });
    </script>
@endsection
