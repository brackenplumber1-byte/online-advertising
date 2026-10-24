# Service descriptions for the Tysons Plumbers Google Business Profile.
# Run this file to regenerate tysons-plumbers-services.md and check the
# 300-character limit Google applies to service descriptions.

SERVICES = [
    ("Plumbing leak detection", None,
     "Hidden leak pushing up your water bill? Tysons Plumbers finds leaks in walls, floors, slabs and underground pipes across Roodepoort and the West Rand, using pressure testing and non-invasive detection so we open up only what we must. Clear report and quote before any repair."),
    ("Plumbing pipe repair", None,
     "Burst, cracked or corroded pipes repaired fast in Roodepoort and surrounds. We fix and replace copper, PVC, HDPE and galvanised pipes, reroute damaged sections and restore water pressure, with neat workmanship and a written quote before we start."),
    ("Shower installation", None,
     "New shower or bathroom renovation? We install shower mixers, rain heads, trays, drains and waterproofing for homes in Roodepoort and the West Rand. Correct falls and sealed joints for a leak-free shower that lasts. Ask for a free quote."),
    ("Tap installation", None,
     "Kitchen, bathroom and outdoor tap installation in Roodepoort. We fit mixers, pillar taps, wall-mounted and garden taps, connect them properly and test for leaks. Supply your own tap or let us recommend a quality, SABS-approved option."),
    ("Tap repair", None,
     "Dripping or stiff tap? We repair leaking taps and mixers in Roodepoort and the West Rand, replacing washers, cartridges, O-rings and valve seats to stop the drip and save water. Quick call-outs and fair, upfront pricing."),
    ("Toilet installation", None,
     "Toilet installation and replacement for homes and businesses in Roodepoort. We fit close-coupled, wall-hung and concealed-cistern toilets, new pans and water-saving dual-flush systems, sealed and tested for a clean, leak-free finish."),
    ("Toilet repair", None,
     "Running cistern, weak flush, leaking pan or blocked toilet? Tysons Plumbers repairs toilets across Roodepoort and the West Rand, replacing flush valves, inlet valves, seals and pan connectors to get everything working and stop wasted water."),
    ("Water heater installation", None,
     "Geyser installation in Roodepoort and the West Rand. We install electric, gas, solar and heat-pump geysers, including drip trays, vacuum breakers and pressure valves to SANS 10254 standards, with a compliance certificate for your insurer."),
    ("Drain cleaning", None,
     "Blocked sink, shower, bath or outside drain? We clear drains fast in Roodepoort using drain machines and high-pressure jetting to remove grease, hair, roots and debris, not just push them further down. Emergency drain unblocking available."),
    ("Outdoor plumbing system repair", None,
     "Outdoor plumbing repairs in Roodepoort: garden taps, irrigation lines, water meter connections, stormwater drains, gullies and underground pipes. We find and fix leaks and damaged lines outside your home with minimal digging."),
    ("Plumbing leak repair", None,
     "Leaks repaired quickly in Roodepoort and the West Rand, from dripping joints and pipe bursts to leaking geysers, toilets and underground lines. We fix the cause, not just the symptom, to protect your home from water damage and high bills."),
    ("Sewer cleaning", None,
     "Sewer line blocked or backing up? Tysons Plumbers clears main sewer lines in Roodepoort with high-pressure jetting and drain machines, removing roots, fat build-up and debris. CCTV camera inspection available to confirm the line is clear."),
    ("Sewer repair", None,
     "Sewer pipe repairs and replacements in Roodepoort and the West Rand. We fix cracked, collapsed and root-damaged sewer lines, replace broken sections and restore proper flow, keeping your property hygienic and compliant."),
    ("Shower repair", None,
     "Shower leaking, low pressure or not getting hot? We repair showers in Roodepoort, including mixer valves, cartridges, shower heads, arms and wastes, and trace leaks behind tiles before they cause damp and damage."),
    ("Waste disposal repair", None,
     "Waste disposal unit jammed, humming or leaking? We repair and replace kitchen waste disposal units in Roodepoort, clear jams, fix leaks and connections, and install new units safely under your sink."),
    ("Water heater repair", None,
     "Burst geyser or no hot water? Tysons Plumbers repairs geysers in Roodepoort and the West Rand: elements, thermostats, pressure valves, drip trays and leaking cylinders. Fast emergency geyser call-outs and help with insurance claims."),
    ("Water tank installation", None,
     "Water tank installation in Roodepoort for load-shedding and water-outage backup. We install JoJo and other water tanks with stands, pumps, pressure systems and full plumbing connections, so your home keeps running when municipal supply stops."),
    ("Water tank repair", None,
     "Water tank repairs in Roodepoort: leaking tanks and fittings, faulty float valves, pump and pressure-system faults, and broken connections. We get your storage tank and backup supply working reliably again."),
    ("jojo tank", "JoJo tank installation",
     "JoJo tank installation and plumbing in Roodepoort and the West Rand. We supply and install JoJo tanks of all sizes, build stands, fit pumps, filters and pressure systems, and connect them to your home for reliable backup water."),
    ("water backup", "Backup water systems",
     "Backup water systems for Roodepoort homes and businesses. We design and install tanks, booster pumps and automatic changeover so you keep water pressure during municipal outages and maintenance. Ask for a free site assessment."),
    ("plumbers roodepoort", "General plumbing",
     "Tysons Plumbers is a trusted local plumber in Roodepoort, serving the West Rand and Johannesburg. From leaks, blocked drains and geysers to bathroom installs and water tanks, we deliver reliable residential and commercial plumbing."),
    ("emergency plumbing services", "Emergency plumbing",
     "Emergency plumber in Roodepoort for burst pipes, burst geysers, major leaks, sewer backups and blocked drains. Tysons Plumbers responds fast to stop the damage and fix the problem. Call now for urgent help."),
]

LIMIT = 300

def main():
    out = ["# Tysons Plumbers – Google Business Profile service descriptions", "",
           "Paste each description into **Edit profile → Services → (service) → Description**. "
           "Every description is under Google's 300-character limit.", ""]
    for current, rename, desc in SERVICES:
        assert len(desc) <= LIMIT, f"{current}: {len(desc)} chars"
        out.append(f"## {rename or current}")
        if rename:
            out.append(f"_Rename the custom service “{current}” to “{rename}”._")
        out.append("")
        out.append(desc)
        out.append("")
        out.append(f"<sub>{len(desc)}/300 characters</sub>")
        out.append("")
    with open("tysons-plumbers-services.md", "w") as f:
        f.write("\n".join(out))
    print("\n".join(f"{len(d):3d}  {r or c}" for c, r, d in SERVICES))

if __name__ == "__main__":
    main()
