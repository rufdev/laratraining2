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
const baseentityurl = '/categories'; // API endpoint for the entity
const baseentityname = 'Category'; // Name of the entity

/* Breadcrumbs */
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: baseentityname,
        href: baseentityurl,
    },
];

/* Define Props */
export interface Category {
    id: number; // Unique identifier for the category
    name: string; // Name of the category
    description: string; // Description of the category
}

/* Define Table Columns */
const columns: ColumnDef<Category>[] = [
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
        accessorKey: 'description', // Column for category description
        header: 'Description',
        cell: ({ row }) => h('div', { class: 'break-words whitespace-normal' }, row.getValue('description')),
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
             <!-- Create Button -->
             <div class="flex items-center gap-2 py-2">
                <div class="ml-auto flex items-center gap-2">
                    <Button class="bg-cyan-500" @click="handleOpenDialogForm"> <Plus class="h-4"></Plus> Create {{ baseentityname }} </Button>
                </div>
            </div>
            <!-- Table -->
            <ReusableTable ref="tableRef" :columns="columns" :baseentityname="baseentityname" :baseentityurl="baseentityurl" />

        </div>
    </AppLayout>
</template>
