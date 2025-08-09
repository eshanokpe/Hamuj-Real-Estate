<?php

namespace Database\Seeders;

use App\Models\BoardMembers;
use Illuminate\Database\Seeder;

class BoardMembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $assets = asset('assets/');
        $data = [

        ['name' => 'Dr. Foluso Amusa , PhD', 'profile' => 'Dr. Foluso Amusa a seasoned professional with over 27 years of experience in governance, risk, and compliance, He has developed a strong expertise in managing complex projects and leading teams. He holds a PhD in Governance, Risk, Compliance, and Financial Crime Prevention from Atlantic International University, an MBA from Anglia Ruskin University, and a Postgraduate Diploma in Governance, Risk, and Compliance from the International Compliance Association.

                He is currently the Founder of THE MORGANS, a company that provides strategic consulting services to businesses and organizations. He  also serves as a Non-Executive Director at The Marie Trust and as the Advisory Board Chair for Nigeria at the Association of Certified Financial Crime Specialists - ACFCS. His skills include project management, social networking, and analytical skills. He is passionate about helping organizations achieve their goals while ensuring ethical and compliant practices',
                 'path_to_image' => asset('assets/amusa.jpeg'), 'position' => 'Founder & Chairman , Advisory  Governing Council '],
       
        
      ['name' => 'Alex Noton', 'profile' => 'Tenacious, collaborative and dynamic CEO / Managing Director, skilled in business transformation, scale-up, revenue growth and new business development. Adept leading high performing teams, managing P&L, decreasing costs, opening new markets and delivering strategic change to drive the business forward. 

                Highly capable of identifying market opportunities, devising systems to deliver tangible solutions and transforming the organisation culture to create a cohesive, forward-thinking workforce. Comfortable managing executive teams, negotiating contracts, developing global marketplace opportunities and bringing new products and services to market', 
                
                'path_to_image' => asset('assets/alex.jpeg'), 'position' => 'Non-Executive Director / Member , Advisory  Governing Council'],
                
        ['name' => 'Gergely Mikola', 'profile' => 'With over twenty years in Corporate Affairs at International Personal Finance Plc, his tenure as Global Corporate Affairs Director has been marked by a steadfast commitment to the strategic management of regulation, reputation, communities, and communication. His teams have thrived on crafting impactful strategies, a testament to their alignment with the company\'s mission to provide accessible personal finance solutions. Previously, as Corporate and Regulatory Affairs Director in Central Europe for BAT, chairman of the British Chamber of Commerce in Hungary, or as a Board member of the Association of Executives, his dedication to governance and strategic oversight aimed to contribute to organizational excellence. His core competencies lie in navigating complex corporate landscapes and empowering teams to achieve shared goals.',
         'path_to_image' => asset('assets/gergely.jpeg'), 'position' => 'Non-Executive Director / Member , Advisory  Governing Council'],
                
                
     ['name' => 'Dr. Farooq Naeem', 'profile' => 'An accomplished leader with over 24 years of expertise in Strategy, supervision, corporate governance, and regulatory compliance. His experience working with leading international financial regulators including the FCA (UK), QFCRA (Qatar), DFSA (UAE), and JFSC (Jersey, Channel Islands) has provided him with extensive knowledge in banking, asset management, insurance, and the Fintech/Digital Assets sectors. He is committed to strategic planning and optimizing control functions, serving as a trusted advisor at the executive level', 
     'path_to_image' => asset('assets/farooq.jpeg'), 'position' => 'Non-Executive Director / Member , Advisory  Governing Council'],
               
               
     ['name' => 'Clare Pryor', 'profile' => 'An outstanding senior Cybersecurity and Technology Leader with considerable experience in consulting and in-house roles most recently Head of Cybersecurity Governance, Risk, and Compliance (GRC) for Visa in Europe. Proven ability to lead diverse global teams, navigate regulatory environments and drive organisational change. 

                Successfully executed critical initiatives, including leading Visa Europe’s compliance with evolving cybersecurity standards, delivering Bank of England-mandated CBEST exercises and managing cybersecurity due diligence for European acquisitions, ensuring operational resilience and business continuity.', 
                'path_to_image' => asset('assets/clare.jpeg'), 'position' => 'Non-Executive Director / Member , Advisory  Governing Council'],
               
     ['name' => 'David (Dave) Harris ', 'profile' => 'Multi skilled logistics professional with 30 + years’ experience in all facets of the industry, covering startups, own account and 3PL operations across multiple verticals. 
                Highly customer orientated with excellent track record in delivering customer expectations and services as contracted whilst reaching or exceeding quantitative targets.',
                 'path_to_image' => asset('assets/david.jpeg'), 'position' => 'Non-Executive Director / Member , Advisory  Governing Council'],
                
     ['name' => 'Mukesh Malhotra, BEM, BCAv, PHF, MSc, CISM', 'profile' => 'Experience of Chairing Local Government, Charity & Voluntary organisations:

                    - as a Non Exec Director in areas of Audit, Risk, Compliance & as a Treasurer.

                    - providing consultancy to the third sector to help improve their effectiveness in areas of Cash flow, project prioritisation & fund raising 

                    - Chair of Pension Fund & Pension Board & specialising in Audit, Risk, Governance 

                    My Professional experience brings many skills:
                    - CISM - Certified Information Security Manager

                    - Global Project Manager, Programme Manager

                    - Creation and Development of Offshore Development Centres

                    - Creation and Development of Global Contact Centres', 
            'path_to_image' => asset('assets/mukesh.png'), 'position' => 'Non-Executive Director / Member , Advisory  Governing Council '],
            ['name' => 'Matthew Kay', 'profile' => 'Matthew holds the CIPP/E, CIPM and a Masters in Information Rights Law and Practice. He also has the BCS certificate in Data Protection as well as IAPP Fellow of Information Privacy.

            He is the Group Data Protection Officer for Shawbrook Group(including Shawbrook Bank, The Mortgage Lender, Bluestone Mortgages Limited and JBR), reporting to the General Counsel, forming part of the legal leadership team and leading the data protection function. He operates under the Seniors Managers Certification Regime(SMCR) as a Material Risk Taker setting the strategy for all aspects of data protection compliance for the group. 

            Before working at Shawbrook he led the Data Protection function for Metro Bank providing strategic leadership to a team of data protection and records management professionals ensuring the bank complied with the UK GDPR and other associated legislation. Part of his role saw him sit on the senior leadership team for the bank with a dotted line into both the Chief Information Officer and the Chief Risk Officer.', 
            'path_to_image' => '', 'position' => ' Non-Executive Director / Member , Advisory  Governing Council '],
            
                 

    ['name'=>'Chris Taylor', 'profile' => 'He is an experienced NED, a former Director of Compliance and a Compliance, Risk, and Governance Specialist, with a proven track record of constructively challenging Board-level strategies, policies, and procedures in Banking and Financial Services.

                His current/recent NED portfolio includes: Non-Executive Director at Devote Care Group, Non-Executive Chair at Lintel Financial Services (seeking a banking license), NED at Guaranty Trust Bank (UK), and Senior NED at BFC Bank. His executive career includes: Director of Compliance and Legal at Lombard Odier London, Compliance Director at TAIB Securities, and Head of Group Funds Management Compliance/Deputy Global Head of Compliance at NatWest Group.

                Recently appointed as a Lay Member of the Financial Reporting Council (FRC) Disciplinary Tribunal Panel (12/22).

                As a Non-Executive Director, he combines his 25+ years of Financial Services Executive leadership experience with 14 years of previous HR leadership in Commercial, Private, and Investment Banking to embed effective governance frameworks while driving performance and cultural change', 
                
            'path_to_image' => asset('assets/chris.jpeg'), 'position' => ' Non-Executive Director / Member , Advisory  Governing Council '],
                
    ['name' => 'Esosa Balogun BSc, FCA, CCSA, CRMA, CIA, MBA', 'profile' => 'He is a certified professional with extensive experience in the areas of Enterprise Risk Management, Internal Audit, Internal Control, Strategy, Finance, Compliance, and Corporate Governance.

                He has been involved in Risk Consulting and Internal Audit services for several clients in the manufacturing, financial services, telecommunications, and oil and gas sectors. With over 15 years experience in delivering risk solutions such as the Design and Implementation of Enterprise Risk Management Frameworks, Internal Audit transformation, Risk Assessments, Internal Control Assessments, Accounting Advisory, Corporate Governance, and Board Advisory Services, he is excited about opportunities to add value to businesses in the areas of risk management, compliance, internal control, audit, and strategy, while working with members of a team.', 
                
                'path_to_image' => asset('assets/esosa.jpg'), 'position' => ' Non-Executive Director / Member , Advisory'],
            ];

            foreach( $data as $da) BoardMembers::create($da);
    }
}
