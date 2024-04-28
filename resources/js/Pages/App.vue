<script setup>
import {ref, watch} from 'vue'
import MembersForm from './MembersForm.vue';
import MemberSubscriptions from './MemberSubscriptions.vue'
import Members from './Members.vue';

const defaultMember = {id: null, name: '', age: '', dni: '', phone: '', picture: null, subscriptions: null, subscription: null }
const props   = defineProps(['members', 'updatedMember', 'createdMember'])
const dialog  = ref(false)
const tab     = ref('profile')
const member  = ref({...defaultMember})
const members = ref([...props.members])

watch(()=>props.createdMember, newVal => members.value.push(newVal))
watch(()=>props.updatedMember, newVal => {
  members.value.splice(members.value.indexOf(member.value), 1, newVal)
  member.value = newVal
})

function selectMember(selected){
  member.value = selected;
  dialog.value = true;
}
</script>

<template>
  <Members
    :members="members"
    @selected="selectMember">
  </Members>

  <q-dialog v-model="dialog">
    <q-card style="width: 560px; margin: 0 auto;">
      <q-tabs active-color="primary" v-model="tab">
        <q-tab name="profile">Perfil</q-tab>
        <q-tab v-if="member" name="subscription" :disable="!Boolean(member.id)">Suscripción</q-tab>
      </q-tabs>
      <q-tab-panels v-model="tab">
        <q-tab-panel name="profile">
          <MembersForm :member="member">
          </MembersForm>
        </q-tab-panel>

        <q-tab-panel name="subscription">
          <MemberSubscriptions :member="member">
          </MemberSubscriptions>
        </q-tab-panel>
      </q-tab-panels>
    </q-card>
  </q-dialog>

  <q-page-sticky :position="'bottom-right'" :offset="[30, 30]">
    <q-btn
      fab
      icon="sym_o_add"
      color="primary"
      @click="()=>{member = {...defaultMember}; dialog=true}">
    </q-btn>
  </q-page-sticky>
</template>
