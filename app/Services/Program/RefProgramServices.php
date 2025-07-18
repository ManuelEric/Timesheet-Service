<?php

namespace App\Services\Program;

use App\Http\Traits\ConcatenateName;
use App\Models\Ref_Program;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RefProgramServices
{
    use ConcatenateName;

    protected $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function createMany(array $request, $command = false, $options = [])
    {
        /**
         * @var mixed
         * 
         * existing_clientprog is used to store existing clientprog_id
         * where refs is used to store new clientprog_id
         */
        $refs = $existing_clientprog = array();
        $no = 1;
        foreach ($request as $crm_success_program) #both b2c & b2b 
        {
            /* define for both b2c and b2b variables */
            $category = $crm_success_program['category'];
            $clientprog_id = $schprog_id = $student_uuid = $student_name = $student_grade = NULL;
            $invoice_id = $crm_success_program['invoice_id'];
            $student_school = $crm_success_program['client']['school_name'];
            $program_name = $crm_success_program['program_name'];
            $require = $crm_success_program['require'];
            $package = $crm_success_program['package'];
            $curriculum = $crm_success_program['curriculum'];
            $engagement_type = $crm_success_program['engagement_type'] ?? null;

            if ($category == 'b2c') {
                /* define b2c variables */
                $clientprog_id = $crm_success_program['clientprog_id'];
                $student_uuid = $crm_success_program['client']['uuid'];
                $student_name = $this->concat($crm_success_program['client']['first_name'], $crm_success_program['client']['last_name']);
                $student_grade = $crm_success_program['client']['grade'];
            }
            
            if ($category == 'b2b') {
                /* define b2b variables */
                $schprog_id = $crm_success_program['schprog_id'];
            }


            /* check existence of success program on timesheet app */
            if ( Ref_Program::whereWetherB2C_B2B($category, $clientprog_id, $schprog_id)->noTrial()->exists() )
            {
                $existing_clientprog[] = $clientprog_id;
                Ref_Program::where('clientprog_id', $clientprog_id)->update([
                    'student_grade' => $student_grade,
                    //? need to update package, curriculum, program_name, 
                    'program_name' => $program_name,
                    'free_trial' => $package == "Free Trial" ? 1 : 0,
                    'package' => $package,
                    'curriculum' => $curriculum,
                    'require' => $require,
                ]); # just update the student grade
                continue; # don't put existing clientprog_id / schprog_id into refs[]
            }

            $refs[] = [
                'category' => $category,
                'clientprog_id' => $clientprog_id,
                'schprog_id' => $schprog_id,
                'invoice_id' => $invoice_id,
                'student_uuid' => $student_uuid,
                'student_name' => $student_name,
                'student_school' => $student_school,
                'student_grade' => $student_grade,
                'program_name' => $program_name,
                'free_trial' => $package == "Free Trial" ? 1 : 0, 
                'require' => $require,
                'package' => $package,
                'curriculum' => $curriculum,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'engagement_type_id' => $engagement_type, // for subject specialist: in order to be able to read in list request
            ];
        }

        DB::beginTransaction();
        try {

            Ref_Program::insert($refs);
            DB::commit();

            # command true means, this function being called from command
            if ( $command )
            {
                $options['progress']->advance();
            }

        } catch (Exception $e) {

            DB::rollBack();
            $this->responseService->storeErrorLog(
                'Failed to create many ref programs.', 
                $e->getMessage(), 
                [
                    'file' => $e->getFile(),
                    'error_line' => $e->getLine()
                ]
            );
            
            throw new Exception($e->getMessage());

        }

        if (count($refs) > 0)
        {
            // get the inserted ref program
            $refs = Ref_Program::whereIn('clientprog_id', array_column($refs, 'clientprog_id'))->get()->toArray();
        }
        else
        {
            // get the existing ref program
            $refs = Ref_Program::whereIn('clientprog_id', $existing_clientprog)->get()->toArray();
        }
        return $refs;
    }

    public function createManySkipRequest(array $request, $command = false, $options = [])
    {
        DB::beginTransaction();
        try {

            foreach ($request as $crm_success_program) #both b2c & b2b 
            {
                /* define for both b2c and b2b variables */
                $clientprog_id = $crm_success_program['clientprog_id'];
                $category = $crm_success_program['category'];
                $invoice_id = $crm_success_program['invoice_id'];
                $student_school = $crm_success_program['client']['school_name'];
                $student_uuid = $crm_success_program['client']['uuid'];
                $student_name = $crm_success_program['client']['first_name'] . ' ' . $crm_success_program['client']['last_name'];
                $student_grade = $crm_success_program['client']['grade'];
                $program_name = $crm_success_program['program_name'];
                $require = $crm_success_program['require'];
                $package = $crm_success_program['package'];
                $curriculum = $crm_success_program['curriculum'];
                $engagement_type = $crm_success_program['engagement_type'] ?? null;

                $created = Ref_Program::create([
                    'category' => $category,
                    'clientprog_id' => $clientprog_id,
                    'invoice_id' => $invoice_id,
                    'student_uuid' => $student_uuid,
                    'student_name' => $student_name,
                    'student_school' => $student_school,
                    'student_grade' => $student_grade,
                    'program_name' => $program_name,
                    'free_trial' => $package == "Free Trial" ? 1 : 0, 
                    'require' => $require,
                    'package' => $package,
                    'curriculum' => $curriculum,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'engagement_type_id' => $engagement_type, // for subject specialist: in order to be able to read in list request
                ]);

                $refs[] = $created->id;
            }
            DB::commit();
        } catch (Exception $e) {

            DB::rollBack();
            $this->responseService->storeErrorLog(
                'Failed to create many ref programs.', 
                $e->getMessage(), 
                [
                    'file' => $e->getFile(),
                    'error_line' => $e->getLine()
                ]
            );
            
            throw new Exception($e->getMessage());

        }
        
        return $refs;
    }

    public function createOne(array $request)
    {
        /**
         * determine logged in user
         * only store the requested_by if user is mentor
         */
        $requested_by = auth('sanctum')->user()->is_admin ? null : auth('sanctum')->user()->id;

        $ref = [
            'category' => 'b2c',
            'clientprog_id' => $request['clientprog_id'],
            'invoice_id' => $request['invoice_id'],
            'student_uuid' => $request['student_uuid'],
            'student_name' => $request['student_name'],
            'student_school' => $request['student_school'],
            'student_grade' => $request['student_grade'],
            'program_name' => $request['program_name'],
            'require' => 'Mentor',
            'engagement_type_id' => $request['engagement_type'],
            'notes' => $request['notes'],
            'requested_by' => $requested_by
        ];

        DB::beginTransaction();
        try {
            $stored = Ref_Program::create($ref);
            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            $this->responseService->storeErrorLog(
                'Failed to create ref program.', 
                $e->getMessage(), 
                [
                    'file' => $e->getFile(),
                    'error_line' => $e->getLine()
                ]
            );
            
            throw new HttpResponseException(
                response()->json([
                    'errors' => 'Failed to create a ref program'
                ])
            );
        }

        return $stored;
    }
}
