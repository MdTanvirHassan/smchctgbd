<style>
    /* Soft, subtle borders for a cleaner look */
    .table td,
    .table th {
        font-size: small;
        border-color: rgba(0, 0, 0, 0.05) !important;
    }

    .card {
        border: 1px solid rgba(0, 0, 0, 0.05) !important;
    }

    .card-header {
        height: 65px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05) !important;
    }

    .modal-content {
        border: 1px solid rgba(0, 0, 0, 0.05) !important;
    }

    /* Subtle rounded pagination buttons */
    #pagination .page-item .page-link {
        border-radius: 0.375rem;
        border: 1px solid #dee2e6;
        color: #495057;
        transition: all 0.2s ease-in-out;
    }

    #pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: #fff;
    }

    #pagination .page-item .page-link:hover {
        background-color: #e9ecef;
        border-color: #dee2e6;
    }

    /* Optional: subtle shadow for pagination */
    #pagination {
        padding: 0.25rem 0;
    }

    /* Showing info text styling */
    #showing-info {
        font-size: 0.875rem;
        /* small text */
        color: #6c757d;
        /* muted gray */
    }
</style>