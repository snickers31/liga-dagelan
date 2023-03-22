<script setup>
import { Head, Link } from "@inertiajs/vue3";
import DialogModal from "../Components/DialogModal.vue";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Head title="Klasemen" />
    <DialogModal :show="dialogKlubBaru">
        <template #title>
            <div>Tambah Klub Baru</div>
        </template>
        <template #content>
            <div class="grid grid-cols-5 gap-y-4 gap-x-2">
                <div class="bg-slate-700 py-2 text-center col-span-1">
                    <span class="font-semibold text-white text-sm"
                        >Nama Klub</span
                    >
                </div>
                <div class="col-span-4">
                    <input
                        v-model="inputNewClub.nama"
                        placeholder="Masukan nama klub disini.."
                        class="w-full border-b-2 border-gray-400 border-t-0 border-l-0 border-r-0 focus:border-b-black focus:ring-0"
                        type="text"
                        name="labelNamaKlub"
                        id="labelNamaKlub"
                    />
                </div>
                <div class="bg-slate-700 py-2 text-center col-span-1">
                    <span class="font-semibold text-sm text-white"
                        >Kota Klub</span
                    >
                </div>
                <div class="col-span-4">
                    <input
                        v-model="inputNewClub.kota"
                        placeholder="Masukan kota klub disini.."
                        class="w-full border-b-2 border-gray-400 border-t-0 border-l-0 border-r-0 focus:border-b-black focus:ring-0"
                        type="text"
                        name="labelNamaKlub"
                        id="labelNamaKlub"
                    />
                </div>
            </div>
        </template>

        <template #footer>
            <div class="flex justify-end">
                <button
                    class="py-1 mr-2 px-6 font-semibold rounded-md bg-transparent text-red-500 flex items-center justify-center"
                    type="button"
                    @click="dialogKlubBaru = false"
                >
                    <span class="material-icons text-xs mr-1 font-bold">
                        close
                    </span>
                    <span class="text-xs">Batal</span>
                </button>
                <button
                    class="py-1 px-6 font-semibold rounded-md bg-green-600 text-white flex items-center justify-center"
                    type="button"
                    @click="simpanKlubBaru()"
                >
                    <span class="material-icons text-xs mr-1 font-bold">
                        save
                    </span>
                    <span class="text-xs">Simpan</span>
                </button>
            </div>
        </template>
    </DialogModal>
    <DialogModal :show="dialogMatchBaru">
        <template #title>
            <div>Buat Data Pertandingan</div>
            <div class="">
                <div
                    class="w-full border-b-2 border-t-0 border-l-0 border-r-0 border-gray-500"
                ></div>
            </div>
        </template>
        <template #content>
            <div
                v-for="(match, index) in newMatchs"
                :key="index"
                class="flex items-center px-4 mb-2 bg-slate-100"
            >
                <div class="pr-2">
                    <button
                        class="font-semibold rounded-md bg-red-600 text-white flex items-center justify-center"
                        type="button"
                        @click="removeMatch(index)"
                    >
                        <span
                            class="material-icons text-xs px-2 py-1 font-bold"
                        >
                            close
                        </span>
                    </button>
                </div>

                <div class="flex items-center w-5/12">
                    <input
                        v-model="match.home_club_name"
                        placeholder="Nama Klub tuan rumah"
                        class="px-2 py-2 flex-grow bg-transparent"
                    />
                    <input
                        type="number"
                        v-model="match.home_club_goals"
                        class="w-20 border-none focus:border-none focus:ring-0 ml-2 bg-transparent text-gray-700 text-lg text-right"
                    />
                </div>

                <span
                    class="flex-grow text-center font-bold text-gray-700 text-lg"
                    >VS</span
                >
                <div class="flex items-center w-5/12">
                    <input
                        type="number"
                        v-model="match.away_club_goals"
                        class="w-20 border-none focus:border-none focus:ring-0 mr-2 bg-transparent text-gray-700 text-lg"
                    />
                    <input
                        v-model="match.away_club_name"
                        placeholder="Nama Klub tuan rumah"
                        class="px-2 py-2 flex-grow bg-transparent"
                    />
                </div>
            </div>
            <button
                class="py-1 px-6 mt-4 w-full font-semibold rounded-md bg-blue-600 text-white flex items-center justify-center"
                type="button"
                @click="tambahMatch()"
            >
                <span class="material-icons text-xs mr-1 font-bold"> add </span>
                <span class="text-xs">Tambah</span>
            </button>
        </template>

        <template #footer>
            <div class="flex justify-end">
                <button
                    class="py-1 mr-2 px-6 font-semibold rounded-md bg-transparent text-red-500 flex items-center justify-center"
                    type="button"
                    @click="dialogMatchBaru = false"
                >
                    <span class="material-icons text-xs mr-1 font-bold">
                        close
                    </span>
                    <span class="text-xs">Batal</span>
                </button>
                <button
                    class="py-1 px-6 font-semibold rounded-md bg-green-600 text-white flex items-center justify-center"
                    type="button"
                    @click="simpanMatch()"
                >
                    <span class="material-icons text-xs mr-1 font-bold">
                        save
                    </span>
                    <span class="text-xs">Simpan</span>
                </button>
            </div>
        </template>
    </DialogModal>
    <div class="min-h-screen bg-gray-200 w-full flex justify-center py-16">
        <div class="w-6/12 bg-white rounded-xl flex flex-col px-6 py-8">
            <div class="flex mb-8">
                <div class="flex flex-col flex-grow">
                    <span class="font-bold text-2xl text-gray-600"
                        >Liga Dagelan Wakanda</span
                    >
                    <span class="text-gray-500">Tahun 2022-2023</span>
                </div>
                <div class="w-3/12 grid grid-cols-1 gap-y-2">
                    <button
                        class="py-1 w-full px-6 font-semibold rounded-md bg-blue-600 text-white flex items-center justify-center"
                        type="button"
                        @click="dialogKlubBaru = true"
                    >
                        <span class="material-icons text-xs mr-1 font-bold">
                            add
                        </span>
                        <span class="text-xs">Data Klub</span>
                    </button>
                    <button
                        class="py-1 w-full px-6 font-semibold rounded-md bg-blue-600 text-white flex items-center justify-center"
                        type="submit"
                        @click="dialogMatchBaru = true"
                    >
                        <span class="material-icons text-xs mr-1 font-bold">
                            add
                        </span>
                        <span class="text-xs">Data Pertandingan</span>
                    </button>
                </div>
            </div>

            <div class="flex-grow overflow-auto">
                <table class="relative w-full border">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Klub</th>
                            <th>Ma</th>
                            <th>Me</th>
                            <th>S</th>
                            <th>K</th>
                            <th>GM</th>
                            <th>GK</th>
                            <th>Point</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y bg-red-100">
                        <tr
                            v-if="!onLoadData && clubs.length > 0"
                            v-for="(club, index) in clubs"
                            :key="index"
                        >
                            <td class="px-6 py-2 text-center">
                                {{ index + 1 }}
                            </td>
                            <td class="px-6 py-2 text-center">
                                {{ club.nama_klub }}
                            </td>
                            <td class="px-6 py-2 text-center">
                                {{ club.main }}
                            </td>
                            <td class="px-6 py-2 text-center">
                                {{ club.menang }}
                            </td>

                            <td class="px-6 py-2 text-center">
                                {{ club.seri }}
                            </td>
                            <td class="px-6 py-2 text-center">
                                {{ club.kalah }}
                            </td>
                            <td class="px-6 py-2 text-center">
                                {{ club.masuk }}
                            </td>
                            <td class="px-6 py-2 text-center">
                                {{ club.kemasukan }}
                            </td>
                            <td class="px-6 py-2 text-center">
                                {{ club.total_points }}
                            </td>
                        </tr>
                        <tr v-else-if="!onLoadData && clubs.length < 1">
                            <td colspan="9" class="bg-white">
                                <div
                                    class="flex justify-center items-center py-4"
                                >
                                    <span>Tidak ada data..</span>
                                </div>
                            </td>
                        </tr>
                        <tr v-else>
                            <td colspan="9" class="bg-white">
                                <div
                                    class="flex justify-center items-center py-4"
                                >
                                    <img
                                        class="w-8"
                                        :src="'/images/base_loading.svg'"
                                    />
                                    <span>Mohon Tunggu</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            onLoadData: false,
            dialogKlubBaru: false,
            dialogMatchBaru: false,
            clubs: [],
            inputNewClub: {
                nama: "",
                kota: "",
            },
            newMatchs: [
                {
                    home_club_name: "",
                    away_club_name: "",
                    home_club_goals: 0,
                    away_club_goals: 0,
                },
            ],
        };
    },
    mounted() {
        this.fetchKlub();
    },
    methods: {
        async fetchKlub() {
            this.onLoadData = true;
            try {
                var result = await axios.get("/klasemen");
                this.clubs = result.data;
                this.onLoadData = false;
            } catch (error) {
                this.onLoadData = false;
                alert("Terjadi Kesalahan");
            }
        },
        async simpanKlubBaru() {
            this.onLoadData = true;
            try {
                var result = await axios.post("/klub", this.inputNewClub);
                this.onLoadData = false;
                window.location.reload();
            } catch (error) {
                this.onLoadData = false;
                alert(error.response.data);
            }
        },
        async simpanMatch() {
            this.onLoadData = true;
            try {
                var result = await axios.post("/match", {
                    matchs: this.newMatchs,
                });
                this.onLoadData = false;
                window.location.reload();
            } catch (error) {
                this.onLoadData = false;
                alert(error.response.data);
            }
        },
        tambahMatch() {
            this.newMatchs.push({
                home_club_name: "",
                away_club_name: "",
                home_club_goals: 0,
                away_club_goals: 0,
            });
        },
        removeMatch(index) {
            this.newMatchs.splice(index, 1);
        },
    },
};
</script>

<style></style>
