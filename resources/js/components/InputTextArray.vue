<script>
import { defineComponent } from 'vue';
export default defineComponent({
    props: ['modelValue'],
    data() {
        return {
            rows: null,
            texts: null,
            default: [{ text: null }],
        };
    },
    created() {
        this.rows = this.modelValue ? this.parser() : this.default;
    },

    methods: {
        addRow() {
            this.$refs.tree.add({ text: null });
            this.save();
        },
        removeRow(stat) {
            if (this.rows.length > 1) {
                this.$refs.tree.remove(stat);
            }
            this.save();
        },
        save() {
            this.texts = this.$refs.tree.getData().filter(function (obj) {
                return obj.text != null;
            });
            this.$emit('update:modelValue', JSON.stringify(this.texts));
        },
        parser() {
            try {
                return JSON.parse(this.modelValue);
            } catch (error) {
                return this.modelValue.length == 0 ? this.default : this.modelValue;
            }
        },
        uploaded(stat) {
            this.save();
        },
    },
});
</script>

<template>
    <div>
        <Draggable v-model="rows" ref="tree" virtualization :maxLevel="1" :watermark="false">
            <template #default="{ node, stat }">
                <span v-if="stat.children.length" @click="stat.open = !stat.open">
                    {{ stat.open ? '-' : '+' }}
                </span>
                <div class="mb-5 w-full">
                    <div class="flex w-full">
                        <a @click="removeRow(stat)" class="block justify-center px-3 py-3 text-center">
                            <i class="fas text-grey-400 fa-vector-square mr-2 cursor-move text-sm"></i>
                        </a>
                        <div class="mr-4 w-full flex-initial">
                            <input
                                type="text"
                                class="focus:ring-opacity-50 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200"
                                placeholder="Text"
                                v-model="node.text"
                                @change="save"
                            />
                        </div>
                        <a @click="removeRow(stat)" class="block cursor-pointer justify-center px-3 py-3 text-center">
                            <i class="fas fa-trash mr-2 text-sm text-red-400"></i>
                        </a>
                    </div>
                </div>
            </template>
        </Draggable>
        <div class="flex w-full px-12">
            <SecondaryButton @click="addRow" type="button" class="justify-center">
                <i class="fas text-white-400 fa-plus text-sm"></i> Add New Text</SecondaryButton
            >
        </div>
    </div>
</template>
<style>
.vtlist.he-tree {
    overflow: unset !important;
}
</style>
