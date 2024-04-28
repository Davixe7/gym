<script setup>
const emit    = defineEmits(['selected'])
const props   = defineProps(['members'])
const columns = [
  {name: 'picture', label: 'Foto', align: 'left'},
  {name: 'name', label: 'Nombre', field: 'name', align: 'left'},
  {name: 'dni',  label: 'Cédula', field: 'dni', align: 'left'},
  {name: 'age',  label: 'Edad', field: 'age', align: 'left'},
  {name: 'opts', label: 'Acciones', align: 'right'},
]
</script>

<template>
  <q-table
    flat
    :title="'Miembros'"
    :columns="columns"
    :rows="props.members">

    <template v-slot:body-cell-picture="props">
      <q-td>
        <q-avatar v-if="props.row.picture">
          <q-img :src="props.row.picture"></q-img>
        </q-avatar>
      </q-td>
    </template>

    <template v-slot:body-cell-opts="props">
      <q-td class="text-right">
        <q-btn flat round icon="sym_o_edit" @click="emit('selected', props.row)"></q-btn>
      </q-td>
    </template>
  </q-table>
</template>

<style>
.q-table__card {
  background: none;
}
</style>
