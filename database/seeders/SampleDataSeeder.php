<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\NationalProductivityCompetition;
use App\Models\CommunityModelVillage;
use App\Models\CitizenMirror;
use App\Models\ProYouthVideo;
use App\Models\ProYouthProposal;
use App\Models\SelectedParticipant;
use App\Models\FiveSCertification;
use App\Models\CertificationCourse;
use App\Models\TrainingProgram;
use App\Models\Officer;
use App\Models\GalleryImage;
use App\Models\Archive;
use App\Models\Notification;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. NPC
        NationalProductivityCompetition::create([
            'received_allocation' => 'Yes',
            'vote_number' => 'V-2026-NPC-01',
            'amount' => 500000.00,
            'conducted_date' => '2026-05-10',
            'place' => 'Divisional Secretariat Auditorium, Colombo',
            'participants_public' => 45,
            'participants_school' => 120,
            'participants_private' => 30,
            'public_applications_count' => 50,
            'public_selected_count' => 15,
            'place_1st_count' => 1,
            'place_2nd_count' => 1,
            'place_3rd_count' => 1,
            'speech_comm_count' => 5,
            'app_comm_count' => 8
        ]);

        NationalProductivityCompetition::create([
            'received_allocation' => 'Yes',
            'vote_number' => 'V-2026-NPC-02',
            'amount' => 350000.00,
            'conducted_date' => '2026-06-02',
            'place' => 'Gampaha Town Hall',
            'participants_public' => 20,
            'participants_school' => 80,
            'participants_private' => 15,
            'public_applications_count' => 25,
            'public_selected_count' => 8,
            'place_1st_count' => 1,
            'place_2nd_count' => 1,
            'place_3rd_count' => 1,
            'speech_comm_count' => 2,
            'app_comm_count' => 4
        ]);

        // 2. Community Model Village
        CommunityModelVillage::create([
            'district_allocation' => 1200000.00,
            'vote_number' => 'V-2026-CMV-05',
            'date' => '2026-04-15',
            'amount' => 750000.00,
            'purpose' => 'Establishment of sustainable home garden model and micro-finance awareness.',
            'division_name' => 'Kaduwela',
            'gn_division' => 'Kaduwela South (478B)',
            'village' => 'Welihinda East',
            'contacted_staff' => 'Mr. P. B. Jayasundara (Gramasevaka)',
            'awareness_date' => '2026-04-18',
            'stakeholder_awareness_date' => '2026-04-20',
            'participants_count' => 60,
            'launching_date' => '2026-05-01',
            'ceremony_participants_count' => 150
        ]);

        // 3. Citizen Mirror
        CitizenMirror::create([
            'title' => 'Division Waste Management Evaluation',
            'description' => 'A public feedback session on local environmental and waste collection productivity.',
            'date' => '2026-05-22',
            'division' => 'Maharagama',
            'document_path' => null
        ]);

        // 4. ProYouth Video
        $v1 = ProYouthVideo::create([
            'name' => 'Kavindu Senanayake',
            'nic_number' => '200115609452',
            'address' => '45/2, Temple Road, Maharagama',
            'age' => 24,
            'ds_division' => 'Maharagama',
            'institute_school' => 'University of Moratuwa',
            'video_link' => 'https://youtube.com/watch?v=demo1'
        ]);

        $v2 = ProYouthVideo::create([
            'name' => 'Anura Perera',
            'nic_number' => '200234509121',
            'address' => '12, School Lane, Kottawa',
            'age' => 23,
            'ds_division' => 'Maharagama',
            'institute_school' => 'President\'s College',
            'video_link' => 'https://youtube.com/watch?v=demo2'
        ]);

        // 5. ProYouth Proposal
        $p1 = ProYouthProposal::create([
            'name' => 'Minoli Gunawardena',
            'nic_number' => '200078901234',
            'address' => '78, Galle Road, Colombo 03',
            'age' => 25,
            'ds_division' => 'Thimbirigasyaya',
            'institute_school' => 'IIT Sri Lanka',
            'proposal_link' => 'https://drive.google.com/file/d/demo_proposal'
        ]);

        // 6. Selected Participants / Marks
        SelectedParticipant::create([
            'proyouth_type' => ProYouthVideo::class,
            'proyouth_id' => $v1->id,
            'marks' => 88,
            'is_winner' => true
        ]);

        SelectedParticipant::create([
            'proyouth_type' => ProYouthVideo::class,
            'proyouth_id' => $v2->id,
            'marks' => 74,
            'is_winner' => false
        ]);

        SelectedParticipant::create([
            'proyouth_type' => ProYouthProposal::class,
            'proyouth_id' => $p1->id,
            'marks' => 92,
            'is_winner' => true
        ]);

        // 7. 5S Certification
        FiveSCertification::create([
            'program_name' => 'Divisional Hospital 5S Rollout',
            'institution' => 'Base Hospital Homagama',
            'date' => '2026-03-10',
            'division' => 'Homagama',
            'participants_count' => 80,
            'status' => 'Certified',
            'document_path' => null
        ]);

        FiveSCertification::create([
            'program_name' => 'DS Office 5S Audit & Cleanliness Program',
            'institution' => 'Kaduwela Divisional Secretariat',
            'date' => '2026-06-12',
            'division' => 'Kaduwela',
            'participants_count' => 45,
            'status' => 'Pending',
            'document_path' => null
        ]);

        // 8. Certification Course
        CertificationCourse::create([
            'year' => 2026,
            'institution' => 'National Institute of Productivity Studies',
            'students_count' => 40,
            'modules_count' => 6,
            'starting_date' => '2026-02-01',
            'closing_date' => '2026-08-30',
            'exam_date' => '2026-08-15',
            'eligible_students_count' => 38,
            'ceremony_date' => null
        ]);

        // 9. Training Program
        TrainingProgram::create([
            'date' => '2026-05-18',
            'institution' => 'Public Sector Productivity Unit',
            'district' => 'Colombo',
            'participants_count' => 50
        ]);

        // 10. Officers
        Officer::create([
            'name' => 'Ruslan Senadheera',
            'division_name' => 'Maharagama DS Division',
            'nic_number' => '199214709841',
            'appointment_date' => '2018-05-12',
            'service_details' => 'Productivity Development Officer (Class II) - 8 years in DS administration.',
            'photo_path' => null
        ]);

        // 11. Notifications
        Notification::create([
            'title' => 'Upcoming 5S Certification Audit',
            'message' => '5S audit for Kaduwela Divisional Secretariat is scheduled next week. Please complete validation checks.',
            'read' => false
        ]);

        Notification::create([
            'title' => 'NPC Proposal Deadline',
            'message' => 'Criteria program details and applications for the National Productivity Competition are closing soon.',
            'read' => true
        ]);
    }
}
