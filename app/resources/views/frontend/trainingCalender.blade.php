  <style>
    /* Remove all borders from table, th, and td */
    table.table,
    table.table th,
    table.table td {
        border: none !important;
    }

    /* Header background */
    table.table thead th {
        background-color: #E8E8E8 !important;
        text-align: left;
        padding: 8px;
    }

    /* Table body padding */
    table.table td {
        padding: 8px;
        vertical-align: top;
    }
</style>

@extends('layouts.app')

@section('content')

<!--======  Start Page Hero Section  ======-->
<section class="page-hero bg_cover p-r z-1"  style="background-image: url('{{ asset('assets/images/innerpage/bg/page-bg.png') }}');">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="page-content text-center">
                    <h2 class="text-black">Training Calender </h2>
                    <p class="mb-30">
                    View upcoming courses, workshops, and programmes at IGRCFP. Choose the format and dates that work for you.
                    </p>
                    <a style="border-radius: 8px" href="{{ route('training-calender') }}" class="theme-btn style-two">Download Prospectus</a>

                </div>
            </div>
        </div>
    </div>
</section><!--======  End Page Hero Section  ======-->

<!--======  Start Counter Section  ======-->

<!--======  Start Features Section  ======-->
<section class="bizzen-grow-sec pt-50 pb-70">
    <div class="container">
        <div class="row text-left">
            <div class="section-title mb-4">
                <h2 class="text-anm">Training Calender</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <!--=== Bizzen Content Box ===-->
                <div class="bizzen-content-box mb-20">
                    <div class="table-responsive">
                      
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Quarter</th>
                                    <th>Course</th>
                                    <th>Dates</th>
                                    <th>Mode</th>
                                    <th>Target Audience</th>
                                </tr>
                            </thead>

                            <tbody>
                                <!-- Q1 2025 -->
                                <tr >
                                    <td rowspan="2">Q1 2025</td>
                                    <td>Certified GRC & Financial Crime Specialist (CGFCS)</td>
                                    <td>Jan 20 – Mar 14, 2025</td>
                                    <td>Online (8 weeks)</td>
                                    <td>Compliance officers, AML specialists, risk practitioners</td>
                                </tr>
                                <tr style="border-bottom: 2px solid #eee">
                                    <td>Cybersecurity & Data Security for Financial Institutions</td>
                                    <td>Feb 10 – Feb 14, 2025</td>
                                    <td>In-person (Lagos, Nigeria)</td>
                                    <td>IT security managers, CISOs, compliance & audit leaders</td>
                                </tr>

                                <!-- Q2 2025 -->
                                <tr>
                                    <td rowspan="3">Q2 2025</td>
                                    <td>RegTech, SupTech & Innovation in Compliance</td>
                                    <td>Apr 7 – May 2, 2025</td>
                                    <td>Online/Hybrid (4 weeks)</td>
                                    <td>Regulators, fintechs, compliance tech teams</td>
                                </tr>
                                <tr>
                                    <td>Monitoring, Reporting & Risk Analytics</td>
                                    <td>May 12 – May 16, 2025</td>
                                    <td>In-person (Johannesburg, South Africa)</td>
                                    <td>Risk managers, reporting officers, regulators</td>
                                </tr>
                                <tr style="border-bottom: 2px solid #eee">
                                    <td>Executive Short Course: ESG & Sustainable Finance Compliance</td>
                                    <td>Jun 9 – Jun 11, 2025</td>
                                    <td>Virtual Masterclass</td>
                                    <td>ESG managers, financial institutions, sustainability officers</td>
                                </tr>

                                <!-- Q3 2025 -->
                                <tr>
                                    <td rowspan="3">Q3 2025</td>
                                    <td>Advanced Diploma in GRC & Financial Crime Prevention</td>
                                    <td>Jul 7 – Dec 12</td>
                                    <td>Hybrid (6 months)</td>
                                    <td>Senior leaders, executives, policy makers</td>
                                </tr>
                                <tr>
                                    <td>InsurTech, FinTech & Emerging Market Compliance</td>
                                    <td>Aug 11 – Aug 15, 2025</td>
                                    <td>In-person (Nairobi, Kenya)</td>
                                    <td>FinTech operators, InsurTech leaders, regulators</td>
                                </tr>
                                <tr style="border-bottom: 2px solid #eee">
                                    <td>Executive Masterclass: AI in Compliance & Risk Management</td>
                                    <td>Sep 15 – Sep 17, 2025</td>
                                    <td>Virtual Masterclass</td>
                                    <td>Compliance leaders, data scientists, risk executives</td>
                                </tr>

                                <!-- Q4 2025 -->
                                <tr>
                                    <td rowspan="2">Q4 2025</td>
                                    <td>Cybersecurity & Data Security for Financial Institutions (2nd Run)</td>
                                    <td>Oct 13 – Oct 17, 2025</td>
                                    <td>In-person (London, UK)</td>
                                    <td>International FIs, IT risk leaders, regulators</td>
                                </tr>
                                <tr style="border-bottom: 2px solid #eee">
                                    <td>Certified GRC & Financial Crime Specialist (CGFCS) – 2nd Cohort</td>
                                    <td>Nov 3 – Dec 19, 2025</td>
                                    <td>Online (8 weeks)</td>
                                    <td>New and mid-career compliance practitioners</td>
                                </tr>

                                <!-- Q1 2026 -->
                                <tr>
                                    <td rowspan="2">Q1 2026</td>
                                    <td>Certified Regulatory Compliance Specialist (CRCS)</td>
                                    <td>Jan 12 – Feb 6, 2026</td>
                                    <td>Online/Hybrid</td>
                                    <td>Compliance officers, legal teams, supervisory bodies</td>
                                </tr>
                                <tr style="border-bottom: 2px solid #eee">
                                    <td>Executive Short Course: Forensic Investigations & Fraud Analytics</td>
                                    <td>Feb 23 – Feb 25, 2026</td>
                                    <td>Virtual Masterclass</td>
                                    <td>Auditors, fraud examiners, investigators</td>
                                </tr>

                                <!-- Q2 2026 -->
                                <tr>
                                    <td rowspan="3">Q2 2026</td>
                                    <td>
                                        Advanced Diploma in GRC & Financial Crime Prevention (2nd Run)
                                    </td>
                                    <td>Apr 6 – Sep 26, 2026</td>
                                    <td>Hybrid (6 months)</td>
                                    <td>Executives & regulators preparing for senior leadership</td>
                                </tr>
                                <tr>
                                    <td>InsurTech, FinTech & Emerging Market Compliance (2nd Run)</td>
                                    <td>May 11 – May 15, 2026</td>
                                    <td>In-person (Dubai, UAE)</td>
                                    <td>Global fintech leaders, InsurTechs, regulators </td>
                                </tr>
                                <tr style="border-bottom: 2px solid #eee">
                                    <td>Executive Masterclass: Global Sanctions & Trade Compliance</td>
                                    <td>Jun 15 – Jun 17, 2026</td>
                                    <td>Virtual Masterclass</td>
                                    <td>Sanctions officers, treasury & trade finance teams</td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>

                <h4 class="mb-15">Delivery Mix</h4>
                <ul class="check-list style-two mb-40" >
                    <li>Online / Hybrid Programmes: Accessible globally with live instructor support.</li>
                    <li>In-person Programmes: Rotating hubs in Lagos, Johannesburg, Nairobi, Dubai, London.</li>
                    <li>Executive Masterclasses: 2–3 day intensive sessions delivered virtually with global faculty.</li>
                 </ul>
            </div>
            
        </div>
    </div>
</section><!--======  End Features Section  ======-->


@endsection()