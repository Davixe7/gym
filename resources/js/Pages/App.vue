<script setup>
import {ref} from 'vue'
import MembersForm from './MembersForm.vue';
import Members from './Members.vue';

const props = defineProps(['members', 'member'])
const defaultMember = { id: null, name: '', age: '', dni: '', phone: '', picture: null }
const member = ref(props.member ? {...props.member} : {...defaultMember})
const dialog = ref(false)
</script>

<template>
  <Members :members="members" @selected="(selected) => {member={...selected}; dialog=true}"></Members>

  <q-page-sticky :position="'bottom-right'" :offset="[30, 30]">
    <q-btn
      fab
      icon="sym_o_add"
      color="primary"
      @click="()=>{
        member = {...defaultMember.defaultMember};
        dialog=true
      }">
    </q-btn>
  </q-page-sticky>

  <q-dialog v-model="dialog">
    <MembersForm :member="member"></MembersForm>
  </q-dialog>
</template>
