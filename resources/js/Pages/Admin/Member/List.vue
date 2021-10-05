<template>
    <div>
        <app-layout>
            <template #header>
                <h2 class=" font-light text-2xl text-gray-800 leading-tight">
                    Members
                </h2>
            </template>

            <div class="overflow-x-auto">

                <div class="py-5">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                            <div>
                                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                                    <div>

                                       <p class="text-green-500 text">Member Generation Notes:</p>

                                       <ul class="list-disc">
                                           <li>
                                               You can add 10 new members by clicking
                                               <span class="bg-gray-200 px-2 py-1 rounded hover:bg-green-300 cursor-pointer" @click="generateNewMembers()">this.</span>
                                           </li>
                                           <li>
                                               You can clear the database and generate 10 new initial members by clicking
                                               <span class="bg-gray-200 px-2 py-1 rounded hover:bg-green-300 cursor-pointer" @click="clearMembers()">this.</span>
                                           </li>
                                       </ul>

                                       <p class="mt-10 text-green-500 text">Optimization Notes:</p>

                                       <ul class="list-disc">
                                           <li>
                                               <span class="bg-gray-200 px-1 py-1 rounded hover:bg-red-300 cursor-pointer" @click="dumpMembers()">Click this</span>
                                               <span class="text-red-600">to dump 100 </span>members and look at the queries/models below.
                                           </li>
                                           <li>
                                               You will notice a certain number of queries that the application needs to request. <span class="text-red-600">Without </span>proper optimization, the application would need to request this certain number of queries everytime someone requests/reloads the page.
                                           </li>
                                           <li>
                                                <span class="text-green-500">With proper caching and optimization</span>, the same data is stored and would only need to be accessed on initial reload. Hence saving request time and server load.   
                                           </li>

                                           <li>
                                                Look at the queries/models numbers and do a quick page reload, you will then notice that the data would still be there but the queries/models requests would be close to if not 0.
                                            </li>

                                       </ul>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="min-w-screen bg-gray-100 flex items-center justify-center bg-gray-100 font-sans overflow-hidden">
                    <div class="w-full lg:w-5/6">
                        <div class="bg-white shadow-md rounded my-6">
                            <table class="min-w-max w-full table-auto">
                                <thead>
                                <tr class="bg-gray-100 text-gray-900 text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Member</th>
                                    <th class="py-3 px-6 text-left">Credit Scores</th>
                                    <th class="py-3 px-6 text-left">Open Credit Accounts</th>
                                    <th class="py-3 px-6 text-left">Verification Status</th>
                                </tr>
                                </thead>
                                <tbody class="text-gray-600 text-sm font-light">
                                <tr v-for="member in memberData" class="border-b border-gray-200 hover:bg-gray-100 cursor-pointer" :class="statusColor(member.status)">
                                    <td class="py-3 px-6 text-left whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex align-items-center items-center">
                                                <div class="ml-3 leading-4">
                                                    <span class="text-gray-900 font-semibold block" style="font-size: 15px">{{ member.full_name }}</span>
                                                    <span class="text-gray-600">{{ member.email }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 text-left">
                                        <div v-if="member.score">
                                            <span class="block leading-4 ">
                                                Value: <span class="font-semibold"> {{ member.score.value }}</span>
                                            </span>
                                            <span class="block leading-4 ">
                                                Provider: <span class="font-semibold"> {{ member.score.provider }}</span>
                                            </span>
                                            <span class="block leading-4 ">
                                                Name: <span class="font-semibold"> {{ member.score.name }}</span>
                                            </span>
                                        </div>
                                        <div v-else>
                                            {{ member.status === 'partial' ? 'Pending' : '-' }}
                                        </div>
                                    </td>
                                    <td class="py-3 px-6">
                                        <div v-if="member.accounts.length" v-for="account in member.accounts"
                                             class="my-2 leading-3">
                                            <span class="block leading-4 ">
                                                Account Balance: <span class="font-semibold"> ${{
                                                    (account.account_balance).toLocaleString()
                                                }}</span>
                                            </span>
                                            <span class="block leading-4 ">
                                                Account #: <span class="font-semibold"> {{ account.account_number }}</span>
                                            </span>
                                        </div>
                                        <div v-else>
                                            {{ member.status === 'partial' ? 'Pending' : '-' }}
                                        </div>
                                    </td>
                                    <td class="py-3 px-6">
                                        <span class="py-1 px-3 rounded-full text-xs">
                                            {{ member.status_label }}
                                        </span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </app-layout>

    </div>

</template>

<script>
import AppLayout from "@/Layouts/AppLayout";

export default {
    name: "List",
    props: ['members'],
    components: {
        AppLayout,
    },
    data () {
        return {
            memberData: this.members.data,
        }
    },
    methods: {
        statusColor(status) {
            if (status === 'active') {
                return 'bg-green-200 text-green-600'
            } else if (status === 'partial') {
                return 'bg-orange-200 text-orange-600'
            } else {
                return 'bg-red-200 text-red-600'
            }
        },
        generateNewMembers()
        {
            axios.get(this.route('members.generate-new-members')).then((response) => {
                this.memberData = response.data;
            });
        },
        clearMembers()
        {
            axios.get(this.route('members.clear-members')).then((response) => {
                this.memberData = response.data;
            });
        },
        dumpMembers()
        {
            axios.get(this.route('members.dump-members')).then((response) => {
                this.memberData = response.data;
            });
        }
    }
};
</script>

<style>

</style>
