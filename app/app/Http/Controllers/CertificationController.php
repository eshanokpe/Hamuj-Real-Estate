<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CertificationController extends Controller
{
    public function index(){
        return view('frontend.certification.index');
    }

    public function showCGFCS(){
        return view('frontend.certification.cgfcs');
    }

    public function diplomaGRC(){
        return view('frontend.certification.diplomaGRC');
    }

    public function cybersecurityFinance(){
        return view('frontend.certification.cybersecurityFinance');
    }

    public function monitoringRiskAnalytics(){
        return view('frontend.certification.monitoringRiskAnalytics');
    }

    public function regulatoryComplianceEngagement(){
        return view('frontend.certification.regulatoryComplianceEngagement');
    }

    public function regTechSupTech(){
        return view('frontend.certification.regTechSupTech');
    }

    public function insurTechFinTechCompliance(){
        return view('frontend.certification.insurTechFinTechCompliance');
    }

    public function executiveMasterclasses(){
        return view('frontend.certification.executiveMasterclasses');
    }
}