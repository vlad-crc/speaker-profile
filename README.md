# Speaker Profiles Module


## Installation

The module installs normally just as any other module. The modules dependencies are handled in the install so there should be no additional actions required.

# Testing Instructions

## Create taxonomy terms

Once the module is installed go to **/admin/structure/taxonomy/manage/expertise/add** and add a couple of terms such as: Banking, Management, Development... Or something that fits the description of a *topic of expertise*.

*This step can be skipped but then we will have nothing for the 'topics of expertise' field when creating a speakers profile.*

## Create Speaker Profiles

Once you have the terms set up you can proceed to the admin page for the speaker entities. **/admin/content/speaker-profile**
Clicking the "**+ Add speaker profile**" button at the top of the page allows you to add new speakers.

## Admin Interface
Once you have a couple of speakers and taxonomy terms added testing the interface should be straightforward. The table should list out the speakers you've created. There are two filters, one for name and the other for topics of expertise.

## Place the Featured Speaker block

Navigate to the Block Layout page **/admin/structure/block**.
Select a region, preferably content, and click **Place Block**.
Search for "**Featured Speaker**" and place it.

## Featured Speaker Block
The block is set up to stay cached for a day, and should display the same speaker the entire day. Clearing the cache should bring up a different speaker, provided that the same speaker is not randomly selected again.
**This will not work until you create at least one speaker**

## Bonus Challenges

**Revisions and Translations**

The entity is set up to support translations and revisions. Revisions can be tested  by editing any speaker. At the bottom of the edit page you will be given an option to create a new revision.

**Speaker Details View Mode**

You can see the custom view mode configured at **/admin/structure/speaker-profile/display/speaker_details**. Here you can switch between the default and custom view mode.

**User Friendly URL**

The speaker pages follow a pattern of **/speaker-profile/{id}?name={name}**. This pattern allows for a bit more user friendly url's without causing issues. If we followed the **/speaker-profile/{name}** pattern we would have issues as soon as two speakers have the same name.

**Pitfalls of caching strategy for Featured Speaker**

Caching a dynamic content block can cause issues mainly with causing our application to display stale information. For example, if the speakers details are changed during our cached period the component will keep displaying the outdated data it retrieved from the last cron job cache invalidation.
