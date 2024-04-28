<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3';
const props = defineProps(['member'])
const form  = useForm({member_id: props.member.id, membership_id: 1})

function subscribe(){
  if( !window.confirm('Seguro que desea renovar la suscripción?') ){ return; }
  form
  .transform(data=>({...data, only: ['updatedMember']}))
  .post(`/members/${props.member.id}/subscribe`, {
    only: ['updatedMember'],
    onSuccess:() => alert('Suscrito con éxito')
  })
}

const columns = ref([
  {name: 'name', field: row => row.membership.name, label: 'Membresía', align: 'left'},
  {name: 'created_at', field: 'created_at', label: 'Inició', align: 'left'},
  {name: 'expires_at', field: 'expires_at', label: 'Vence', align: 'left'},
  {name: 'status',     field: 'status', label: 'Status', align: 'right'},
])
</script>

<template>
  <div class="flex items-center q-mb-md">
    <q-avatar
      rounded
      size="60px"
      class="q-mr-md"
      color="grey">
    </q-avatar>

    <div v-if="member.subscription">
      <div style="font-weight: 500; font-size: 18px;">
        {{ member.subscription.membership.name }}
      </div>
      <div class="text-caption">
        Válida hasta el {{ member.subscription.expires_at }}
      </div>
    </div>

    <div v-else>
      <div style="font-weight: 500; font-size: 18px;">
        Sin suscripción
      </div>
      <div class="text-caption">
        Sin acceso concedido
      </div>
    </div>

    <q-btn
      outline
      :loading="form.processing"
      class="q-ml-auto"
      style="text-transform: none;
      border-radius: 5px;"
      @click="subscribe">
      Renovar Suscripción
    </q-btn>
  </div>

  <q-table
    v-if="props.member.subscriptions && props.member.subscriptions.length"
    flat
    :columns="columns"
    :rows="member.subscriptions"
    hide-bottom>
    <template v-slot:body-cell-status="props">
      <q-td class="text-right">
        <q-chip glossy :color="props.row.status == 'expired' ? 'red-3' : 'green-3'" :label="props.row.status" />
      </q-td>
    </template>
  </q-table>
</template>
