<?php

global $arrLangs;

include $arrConfig['dir_site'] . '/include/constants.inc.php';

$arrLangs = [
  // Errors
  "ErrorFillAllFields" => "Please fill in all fields.",
  "ErrorPasswordsDontMatch" => "Passwords do not match.",
  "ErrorEmailAlreadyExists" => "Email already exists.",
  "ErrorInvalidCredentials" => "Invalid credentials.",
  "ErrorSendingMessage" => "An error occurred while sending the message. Please try again.",

  // Success
  "SuccessMessageSent" => "The message was sent successfully. Thank you!",

  // Pages
  "Home" => "Home",
  "About" => "About",

  // Header
  "Help" => "Help",
  "Language" => "Language",
  "Download" => "Install", // Changed to "Install"
  "LearnMore" => "Learn More",

  // Footer
  "Navigation" => "Navigation",
  "Start" => "Start",

  // Waitlist
  "JoinWaitlist" => "Join the Waitlist",
  "JoinWaitlistSubtitle" => "Sign up to be notified when the platform is available.",
  "EmailPlaceholder" => "Email",
  "ReceiveEmailUpdates" => "Receive email updates",
  "Join" => "Sign Up",
  "WaitlistSuccess" => "Thank you for signing up! You will be notified when the platform is available to you.",

  // Home Page
  "HeroSlogan" => "Actually Social<br>Social Media",
  "HeroSubtitle" => "We don't sell your data. We don't track you.<br>We don't try to keep you on the platform longer <em>(in fact, quite the opposite)</em>.<br>Have fun with your friends, share photos, and create memories. <strong>That's it.</strong>",
  "BroughtBy" => "Brought to you by",

  // About Page
  "AboutUs" => "About Us",
  "AboutUsSubtitle" => "Meet our team and our mission.",
  "WelcomeTitle" => "Who We Are",
  "WelcomeSubtitle1" => "Welcome to The Actual World – The Real World, your new social network dedicated to strengthening authentic bonds in a safe and private environment. We were born in Porto, Portugal, with the vision of transforming the way we interact online.",
  "WelcomeSubtitle2" => "In a digital age where privacy is rare and online time can affect our mental health, we decided to counteract. Our mission is to provide a platform where you can control who you share your memories and moments with, in an ad-free and invasive algorithm-free environment.",
  "OurMission" => "Our Mission",
  "OurMissionSubtitle" => "Reconnecting the digital world to the real world, promoting meaningful interactions, uncompromising privacy, and a healthy balance between online and offline life.",
  "OurTeam" => "Our Team",

  // Help Page
  "HelpTitle" => "Need Help?",
  "HelpSubtitle" => "Find answers to your questions",
  "HelpSubtitle2" => "about ",
  "HelpSubtitle3" => ", as well as the rest of the platform!",

  // Pricing Page
  "Pricing" => "Pricing",
  "OurPrices" => "Our Prices",
  "OurPricesSubtitle" => "We believe that users of any social network should remain the customers, not the product.",
  "PricingPageHTML" => "
    <p>At The Actual World, we believe that users of any social network should remain the customers, not the product. Therefore, we do not sell your data to third parties.</p>
    <p>Instead, our revenue comes from user subscriptions, which funds the platform.</p>
    <p>Credits are what pays for the social network! The only way to get credits is by buying them, or receiving them from friends (as gifts), however, all users start with {$CONSTANTS['InitialCredits']} credits.</p>
    <p>Our team believes that credits are the most transparent way to pay for the social network.</p>
    <p>Credits are deducted from your account based on what you use, in this case:</p>
    <ul>
      <li><strong>{$CONSTANTS['CreditsPerDayNormal']} credits per day</strong>, that is, ~<{$CONSTANTS['EurosPerMonthNormal']}€ per month ({$CONSTANTS['EurosPerYearNormal']}€ per year) since, even if you do not use the social network, your account continues to be maintained, as well as photos and conversations.</li>
      <li><strong>{$CONSTANTS['CreditsPerGBPerDay']} credits per day per GB of attachments stored</strong>, that is, ~{$CONSTANTS['EurosPerExampleGBPerMonth']}€ per month ({$CONSTANTS['EurosPerExampleGBPerYear']}€ per year) if you have {$CONSTANTS['ExampleGB']} GB of attachments stored.</li>
      <li><strong>{$CONSTANTS['CreditsPerSummary']} credits for each daily summary you generate </strong> ({$CONSTANTS['EurosPerSummary']}€ per summary).</li>
    </ul>
  ",

  // Catalog Page
  "Catalog" => "Catalog",
  "CatalogSubtitle" => "Want to dress stylishly and support online privacy? Here you will find the best options.",
  "ViewProduct" => "View Product",

  // Product Page
  "Product" => "Product",
  "Images" => "Images",
  "Attributes" => "Attributes",
  "Description" => "Description",
  "Buy" => "Buy",
  "AddToCart" => "Add to Cart",

  // Updates Page
  "UpdatesSubtitle" => "Stay up to date with the latest news and improvements on the platform.",
  "UpdatesKeywords" => "updates, news, improvements, fixes",
  "Previous" => "Previous",
  "Next" => "Next",
  "ReadMore" => "Read More",
  "NewFeature" => "New Feature",
  "Improvement" => "Improvement",
  "BugFix" => "Fix",

  // Update Page
  "Update" => "Update",
  "WhatWasUpdated" => "What was updated?",

  // Contact Page
  "Contact" => "Contact",
  "Message" => "Message",
  "Email" => "Email",
  "Name" => "Name",
  "Title" => "Title",
  "Send" => "Send",
  "ContactUs" => "Contact Us",
  "ContactUsSubtitle" => "If you have any questions, suggestions, or recommendations, contact us. We are here to help you.",
  "StartContact" => "Get in touch",
  "StartContactSubtitle" => "Do you have recommendations, suggestions, or questions? Get in touch with us.",

  // CTA Section
  "CTATitle" => "Start sharing your memories with those who really matter now.",

  // Months
  "January" => "January",
  "February" => "February",
  "March" => "March",
  "April" => "April",
  "May" => "May",
  "June" => "June",
  "July" => "July",
  "August" => "August",
  "September" => "September",
  "October" => "October",
  "November" => "November",
  "December" => "December",

  // Tables
  "Pages" => "Pages",
  "Content" => "Content",
  "Menu" => "Menu",
  "Updates" => "Updates",
  "FAQ" => "Help",
  "FAQCategories" => "Help Categories",
  "Logs" => "Logs",
  "Sponsors" => "Sponsors",
  "Products" => "Products",
  "ProductAttributes" => "Product Attributes",
  "ProductImages" => "Product Images",
  "Testimonials" => "Testimonials",
  "Features" => "Features",
  "Steps" => "Steps",
  "Team" => "Team",
  "OurMissionSections" => "Our Mission Sections",
  "Messages" => "Messages",
  "Users" => "Users",

  // Configuration
  "_Timezone" => "Europe/Lisbon",
  "_Locale" => "pt_PT",
  "_LocaleFallback" => "pt_PT.utf-8",
  "_LocaleNextFallback" => "portuguese",

  // Others
  "GlobalPageTitle" => "The Actual World",
  "GlobalPageTitleSuffix" => " - TAW",
  "GlobalPageDescription" => "Transparent, Actually Social Social Media",
  "GlobalPageKeywords" => "social network, privacy, security, transparency, friends, sharing, photos, memories",
  "GlobalPageDescriptionSuffix" => " - The social network that respects you: The Actual World",
];