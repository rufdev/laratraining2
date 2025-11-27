<script setup lang="ts">
/* Import Components */
import ReusableDropDownAction from '@/components/entitycomponents/ReusableDropDownAction.vue'; // Dropdown for row actions (edit/delete)
import ReusableTable from '@/components/entitycomponents/ReusableTable.vue'; // Table component for displaying data
import { Button } from '@/components/ui/button'; // Button component
import { Checkbox } from '@/components/ui/checkbox'; // Checkbox component for row selection
import AppLayout from '@/layouts/AppLayout.vue'; // Layout component for the page
import { Head } from '@inertiajs/vue3'; // Head component for setting the page title

/* Import Table Utilities */
import type { ColumnDef } from '@tanstack/vue-table'; // Type definitions for table columns

/* Import Types */
import { BreadcrumbItem } from '@/types'; // Type definition for breadcrumbs
import { h } from 'vue';
import { ArrowUpDown } from 'lucide-vue-next';

/* Base Entity Configuration */
const baseentityurl = '/assets'; // API endpoint for the entity
const baseentityname = 'Asset'; // Name of the entity

/* Breadcrumbs */
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: baseentityname,
        href: baseentityurl,
    },
];


const props = defineProps({
    categories: {
        type: Object,
        required: true,
    },
    locations: {
        type: Object,
        required: true,
    },
    manufacturers: {
        type: Object,
        required: true,
    },
    users: {
        type: Object,
        required: true,
    },
});

/* Define Props */
export interface Asset {
    id: number;
    category: any;
    category_id: string;
    location: any;
    location_id: string;
    manufacturer: any;
    manufacturer_id: string;
    assigned_to: any;
    assigned_to_user_id: string;
    asset_tag: string;
    name: string;
    serial_number: string;
    model_name: string;
    purchase_date: string;
    purchase_price: any;
    status: string;
    notes: string;
}

const statusEnum = {
    Deployed: 'Deployed',
    InStorage: 'In Storage',
    Maintenance: 'Maintenance',
    Retired: 'Retired',
    Broken: 'Broken',
};

/* Define Table Columns */
const columns: ColumnDef<Asset>[] = [
    {
        id: 'select', // Column for row selection
        header: ({ table }) =>
            h(Checkbox, {
                modelValue: table.getIsAllPageRowsSelected() || (table.getIsSomePageRowsSelected() && 'indeterminate'),
                'onUpdate:modelValue': (value) => table.toggleAllPageRowsSelected(!!value),
                ariaLabel: 'Select all',
            }),
        cell: ({ row }) =>
            h(Checkbox, {
                modelValue: row.getIsSelected(),
                'onUpdate:modelValue': (value) => row.toggleSelected(!!value),
                ariaLabel: 'Select row',
            }),
        enableSorting: false, // Disable sorting for this column
        enableHiding: false, // Disable hiding for this column
    },
    {
        accessorKey: 'name', // Column for category name
        header: ({ column }) => {
            return h(
                Button,
                {
                    variant: 'ghost',
                    onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
                },
                () => ['Name', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })],
            );
        },
        cell: ({ row }) => h('div', { class: 'break-words whitespace-normal' }, row.getValue('name')),
    },
    {
        accessorKey: 'asset_tag',
        header: 'Asset Tag',
        cell: ({ row }) => h('div', { class: 'break-words whitespace-normal' }, row.getValue('asset_tag')),
    },
    {
        accessorKey: 'category.name',
        header: 'Category',
        cell: ({ row }) => h('div', { class: 'break-words whitespace-normal' }, row.original.category?.name || ''),
    },
    {
        accessorKey: 'location.name',
        header: 'Location',
        cell: ({ row }) => h('div', { class: 'break-words whitespace-normal' }, row.original.location?.name || ''),
    },
    {
        accessorKey: 'manufacturer.name',
        header: 'Manufacturer',
        cell: ({ row }) => h('div', { class: 'break-words whitespace-normal' }, row.original.manufacturer?.name || ''),
    },
    {
        accessorKey: 'assigned_to.name',
        header: 'Assigned To User',
        cell: ({ row }) => h('div', { class: 'break-words whitespace-normal' }, row.original.assigned_to?.name || ''),
    },
    {
        accessorKey: 'status',
        header: 'Status',
        cell: ({ row }) => {
            const status = row.original.status;
            let colorClass = '';

            // Define color classes based on statusEnum values
            const statusColors = {
                [statusEnum.Deployed]: 'text-green-500',
                [statusEnum.InStorage]: 'text-blue-500',
                [statusEnum.Maintenance]: 'text-yellow-500',
                [statusEnum.Retired]: 'text-gray-500',
                [statusEnum.Broken]: 'text-red-500',
            };

            colorClass = statusColors[status] || 'text-black';

            return h('div', { class: `break-words whitespace-normal ${colorClass}` }, status);
        },
    },
    { 
        id: 'actions', // Column for row actions (edit/delete)
        enableHiding: false, // Disable hiding for this column
        cell: ({ row }) => {
            const rowitem = row.original;

            return h(
                'div',
                { class: 'relative' },
                h(ReusableDropDownAction, {
                    rowitem,
                    onEdit: undefined, // Edit handler
                    onDelete: undefined, // Delete handler
                }),
            );
        },
    },
];


</script>

<template>
    <!-- Page Title -->
    <Head :title="baseentityname" />
    <!-- Layout -->
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-2 rounded-xl p-4">

            <!-- Table -->
            <ReusableTable ref="tableRef" :columns="columns" :baseentityname="baseentityname" :baseentityurl="baseentityurl" />

        </div>
    </AppLayout>
</template>
