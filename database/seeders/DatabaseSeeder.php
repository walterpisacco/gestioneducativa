<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AcademicSettingSeeder::class,
            PermissionSeeder::class,
            SchoolsSeeder::class,
            DepartmentTableSeeder::class,
            ClassesTableSeeder::class,
            SectionsTableSeeder::class,
            UsersTableSeeder::class,
            SyllabusesTableSeeder::class,
            NoticesTableSeeder::class,
            EventsTableSeeder::class,
            FeesTableSeeder::class,
            HomeworksTableSeeder::class,
            RoutinesTableSeeder::class,
            NotificationsTableSeeder::class,
            ExamsTableSeeder::class,
            GradesystemsTableSeeder::class,
            CoursesTableSeeder::class,
            GradesTableSeeder::class,
            ExamForClassesTableSeeder::class,
            AttendancesTableSeeder::class,
            FeedbacksTableSeeder::class,
            FormsTableSeeder::class,
            BooksTableSeeder::class,
            MessagesTableSeeder::class,
            FaqsTableSeeder::class,
            IssuedbooksTableSeeder::class,
            AccountsTableSeeder::class,
            AccountSectorsTableSeeder::class,
            StudentinfosTableSeeder::class,
            StudentboardexamsTableSeeder::class,
            CertificateTableSeeder::class,
        ]);
    }
}
