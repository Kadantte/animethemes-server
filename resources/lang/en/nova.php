<?php

declare(strict_types=1);

return [
    'admin' => 'Admin',
    'amount' => 'Amount',
    'anime_create_resource_action_success' => 'The Resource has been created and attached to the Anime',
    'anime_create_resource_action' => 'Create :site Resource for Anime',
    'anime_image_lens' => 'Anime Without :facet Image',
    'anime_name_help' => 'The display title of the Anime. By default, we will use the same title as MAL. Ex: "Bakemonogatari", "Code Geass: Hangyaku no Lelouch", "Dungeon ni Deai wo Motomeru no wa Machigatteiru Darou ka".',
    'anime_resource_lens' => 'Anime Without :site Resource',
    'anime_season_help' => 'The Season in which the Anime premiered. By default, we will use the Premiered Field on the MAL page.',
    'anime_slug_help' => 'Used as the URL Slug / Model Route Key. By default, this should be the Name lowercased and "_" replacing spaces. Shortenings/Abbreviations are also accepted. Ex: "monogatari", "code_geass", "danmachi".',
    'anime_studio_lens' => 'Anime Without Studios',
    'anime_synonym_text_help' => 'For alternative titles, licensed titles, common abbreviations and/or shortenings, ',
    'anime_synonym' => 'Anime Synonym',
    'anime_synonyms' => 'Anime Synonyms',
    'anime_synopsis_help' => 'The brief description of the Anime',
    'anime_theme_slug_help' => 'Used as the URL Slug / Model Route Key. By default, this should be the Type and Sequence lowercased and "_" replacing spaces. These should be unique within the scope of the anime. Ex: "OP", "ED1", "OP2-Dub".',
    'anime_theme_type_help' => 'Is this an OP or an ED?',
    'anime_theme_entries' => 'Anime Theme Entries',
    'anime_theme_entry_episodes_help' => 'The range(s) of episodes that the theme entry is used. Can be left blank if used for all episodes or if there are not episodes as with movies. Ex: "1-", "1-11", "1-2, 10, 12".',
    'anime_theme_entry_notes_help' => 'Any additional information not included in other fields that may be useful',
    'anime_theme_entry_nsfw_help' => 'Does the entry include Not Safe For Work content? Set at your discretion. There will not be rigid guidelines to define when this property should be set.',
    'anime_theme_entry_spoiler_help' => 'Does the entry include content that spoils the show? You may also include up to which episode is spoiled in Notes (Ex: Ep 6 spoilers).',
    'anime_theme_entry_version_help' => 'The Version number of the Theme. Can be left blank if there is only one version. Version is only required if there exist at least 2 in the sequence.',
    'anime_theme_entry' => 'Anime Theme Entry',
    'anime_theme_group_help' => 'For separating sequences belonging to dubs, rebroadcasts, remasters, etc. By default, leave blank.',
    'anime_theme_lens' => 'Anime Without Themes',
    'anime_theme_sequence_help' => 'Numeric ordering of theme. If only one theme of this type exists for the show, this can be left blank.',
    'anime_theme' => 'Anime Theme',
    'anime_themes' => 'Anime Themes',
    'anime_year_help' => 'The Year in which the Anime premiered. By default, we will use the Premiered Field on the MAL page.',
    'anime' => 'Anime',
    'announcement' => 'Announcement',
    'announcements' => 'Announcements',
    'artist_create_resource_action_success' => 'The Resource has been created and attached to the Artist',
    'artist_create_resource_action' => 'Create :site Resource for Artist',
    'artist_image_lens' => 'Artist Without :facet Image',
    'artist_name_help' => 'The display title of the Artist. By default, we will use the same title as MAL, but we will prefer "[Given Name] [Family name]". Ex: "Aimer", "Yui Horie", "Fear, and Loathing in Las Vegas".',
    'artist_resource_lens' => 'Artist Without :site Resource',
    'artist_slug_help' => 'Used as the URL Slug / Model Route Key. By default, this should be the Name lowercased and "_" replacing spaces. Shortenings/Abbreviations are also accepted. Ex: "aimer", "yui_horie", "falilv"',
    'artist_song_lens' => 'Artist Without Songs',
    'artist' => 'Artist',
    'artists' => 'Artists',
    'as_help' => 'Used in place of the Artist name if the performance is made as a character or group/unit member.',
    'as' => 'As',
    'auth' => 'Auth',
    'backfill' => 'Backfill',
    'backfill_anidb_resource_help' => 'Use the Manami Project Anime Offline Database hosted by yuna.moe to find an AniDB mapping from a MAL, Anilist or Kitsu Resource',
    'backfill_anidb_resource' => 'Backfill AniDB Resource',
    'backfill_anilist_resource_help' => 'Use the MAL, Kitsu or AniDB Resource to find an Anilist mapping',
    'backfill_anilist_resource' => 'Backfill Anilist Resource',
    'backfill_anime_studios_help' => 'Use the MAL, Anilist or Kitsu Resource to map Anime Studios',
    'backfill_anime_studios' => 'Backfill Anime Studios',
    'backfill_anime' => 'Backfill Anime',
    'backfill_ann_resource_help' => 'Use the Kitsu resource to find an ANN mapping',
    'backfill_ann_resource' => 'Backfill ANN Resource',
    'backfill_kitsu_resource_help' => 'Use the Kitsu API to find a mapping from a MAL, Anilist, AniDB or ANN Resource',
    'backfill_kitsu_resource' => 'Backfill Kitsu Resource',
    'backfill_images' => 'Backfill Images',
    'backfill_large_cover_help' => 'Use Anilist Resource to map Large Cover Image',
    'backfill_large_cover' => 'Backfill Large Cover',
    'backfill_mal_resource_help' => 'Use the Kitsu, Anilist or AniDB Resource to find a MAL mapping',
    'backfill_mal_resource' => 'Backfill MyAnimeList Resource',
    'backfill_resources' => 'Backfill Resources',
    'backfill_small_cover_help' => 'Use Anilist Resource to map Small Cover Image',
    'backfill_small_cover' => 'Backfill Small Cover',
    'backfill_studio_large_cover_help' => 'Use MAL Resource to map Large Cover Image',
    'backfill_studio' => 'Backfill Studio',
    'backfill_studios' => 'Backfill Studios',
    'balance_balance_help' => 'Current balance of the account with current usage',
    'balance_date_help' => 'The month and year for the balance that we are tracking',
    'balance_frequency_help' => 'The frequency that we are billed by the provider',
    'balance_usage_help' => 'Amount used in the current billing period',
    'balances' => 'Balances',
    'balance' => 'Balance',
    'basename' => 'Basename',
    'billing_service_help' => 'The provider that is billing us',
    'billing_service' => 'Billing Service',
    'billing' => 'Billing',
    'body' => 'Body',
    'cancel' => 'Cancel',
    'change' => 'Change',
    'confirm_new_password' => 'Confirm New Password',
    'confirm' => 'Confirm',
    'content' => 'Content',
    'created_at_end' => 'Created At End',
    'created_at_start' => 'Created At Start',
    'created_at' => 'Created At',
    'current_password' => 'Current Password',
    'date' => 'Date',
    'deleted_at_end' => 'Deleted At End',
    'deleted_at_start' => 'Deleted At Start',
    'deleted_at' => 'Deleted At',
    'description' => 'Description',
    'disabled' => 'Disabled',
    'disable' => 'Disable',
    'document' => 'Document',
    'email' => 'Email',
    'enabled' => 'Enabled',
    'enable' => 'Enable',
    'episodes' => 'Episodes',
    'external_id' => 'External ID',
    'external_resource' => 'External Resource',
    'external_resources' => 'External Resources',
    'facet' => 'Facet',
    'file_properties' => 'File Properties',
    'filename' => 'Filename',
    'frequency' => 'Frequency',
    'generate' => 'Generate',
    'give_permission' => 'Give Permission',
    'give_role' => 'Give Role',
    'groups' => 'Groups',
    'group' => 'Group',
    'id' => 'ID',
    'image_facet_help' => 'The page component that the image is intended for. Example: Is this a small cover image or a large cover image?',
    'image_unlinked_lens' => 'Image Without Anime or Artist',
    'images' => 'Images',
    'image' => 'Image',
    'invitation_accept' => 'Accept Invitation',
    'invitation_message' => 'You have been invited to join AnimeThemes!',
    'invitation_subject' => 'AnimeThemes Invitation',
    'invitations' => 'Invitations',
    'invitation' => 'Invitation',
    'lenses' => 'Lenses',
    'link' => 'Link',
    'lyrics' => 'Lyrics',
    'members' => 'Members',
    'mimetype' => 'MIME Type',
    'misc' => 'Misc',
    'name' => 'Name',
    'nc' => 'NC',
    'new_password' => 'New Password',
    'no' => 'No',
    'notes' => 'Notes',
    'nsfw' => 'NSFW',
    'overlap' => 'Overlap',
    'page_body_help' => 'The content of the Page.',
    'page_name_help' => 'The display title of the Page.',
    'page_slug_help' => 'Used as the URL Slug / Model Route Key. By default, this should be the Name lowercased and "_" replacing spaces.',
    'page' => 'Page',
    'pages' => 'Pages',
    'password' => 'Password',
    'path' => 'Path',
    'permission' => 'Permission',
    'permissions' => 'Permissions',
    'resend_invitation_confirm_message' => 'Are you sure you wish to resend these invitations?',
    'resend_invitation' => 'Resend Invitation',
    'resend' => 'Resend',
    'recently_created' => 'Recently Created',
    'recently_updated' => 'Recently Updated',
    'resent_invitations_for_none' => 'Invitation has not been resent for any selected user',
    'resent_invitations_for_users' => 'Invitation has been resent for :users',
    'resolution' => 'Resolution',
    'resource_as_help' => 'Used to distinguish resources that map to the same artist or anime. For example, Aware! Meisaku-kun has one MAL page and many aniDB pages.',
    'resource_external_id_help' => 'The identifier used by the external site.',
    'resource_link_help' => 'The URL of the resource. Ex: https://myanimelist.net/people/8/, https://anidb.net/creator/3/, https://kaguya.love/',
    'resource_site_help' => 'The site that we are linking to.',
    'resource_unlinked_lens' => 'Resource Without Anime or Artist or Studio',
    'revoke_permission' => 'Revoke Permission',
    'revoke_role' => 'Revoke Role',
    'role' => 'Role',
    'roles' => 'Roles',
    'season' => 'Season',
    'sequence' => 'Sequence',
    'series_name_help' => 'The display title of the Series. Ex: "Monogatari", "Code Geass", "Dungeon ni Deai wo Motomeru no wa Machigatteiru Darou ka".',
    'series_slug_help' => 'Used as the URL Slug / Model Route Key. By default, this should be the Name lowercased and "_" replacing spaces. Shortenings/Abbreviations are also accepted. Ex: "monogatari", "code_geass", "danmachi".',
    'series' => 'Series',
    'service' => 'Service',
    'site' => 'Site',
    'size' => 'Size',
    'slug' => 'Slug',
    'song_artist_lens' => 'Songs Without Artists',
    'song_by_subtitle' => 'By: :by',
    'song_title_help' => 'The title of the song',
    'song' => 'Song',
    'songs' => 'Songs',
    'source' => 'Source',
    'spoiler' => 'Spoiler',
    'status' => 'Status',
    'studio_create_resource_action_success' => 'The Resource has been created and attached to the Studio',
    'studio_create_resource_action' => 'Create :site Resource for Studio',
    'studio_image_lens' => 'Studio Without :facet Image',
    'studio_name_help' => 'The display title of the Studio',
    'studio_resource_lens' => 'Studio Without :site Resource',
    'studio_slug_help' => 'Used as the URL Slug / Model Route Key. By default, this should be the Name lowercased and "_" replacing spaces. Shortenings/Abbreviations are also accepted.',
    'studio_unlinked_lens' => 'Studio Without Anime or Studio',
    'studio' => 'Studio',
    'studios' => 'Studios',
    'subbed' => 'Subbed',
    'synopsis' => 'Synopsis',
    'text' => 'Text',
    'theme_group_help' => 'For separating sequences belonging to dubs, rebroadcasts, remasters, etc. By default, leave blank.',
    'theme_sequence_help' => 'Numeric ordering of theme. If only one theme of this type exists for the show, this can be left blank.',
    'theme_slug_help' => 'Used as the URL Slug / Model Route Key. By default, this should be the Type and Sequence lowercased and "_" replacing spaces. These should be unique within the scope of the anime. Ex: "OP", "ED1", "OP2-Dub".',
    'theme_type_help' => 'Is this an OP or an ED?',
    'theme' => 'Theme',
    'themes' => 'Themes',
    'this_month' => 'This Month',
    'this_week' => 'This Week',
    'this_year' => 'This Year',
    'timestamps' => 'Timestamps',
    'title' => 'Title',
    'today' => 'Today',
    'transaction_amount_help' => 'How much are we being billed for or receiving?',
    'transaction_date_help' => 'The date at which the transaction occurred',
    'transaction_description_help' => 'What is this transaction for?',
    'transaction_external_id_help' => 'The identifier used by the service for this transaction, if applicable',
    'transactions' => 'Transactions',
    'transaction' => 'Transaction',
    'type' => 'Type',
    'uncen' => 'Uncensored',
    'updated_at_end' => 'Updated At End',
    'updated_at_start' => 'Updated At Start',
    'updated_at' => 'Updated At',
    'usage' => 'Usage',
    'user' => 'User',
    'users' => 'Users',
    'verify' => 'Verify',
    'version' => 'Version',
    'video_lyrics_help' => 'Set if this video has subtitles for song lyrics.',
    'video_nc_help' => 'Set if this video is creditless.',
    'video_overlap_help' => 'The degree to which the sequence and episode content overlap. None: No overlap. Transition: partial overlap. Over: full overlap.',
    'video_resolution_help' => 'Frame height of the video',
    'video_resolution_lens' => 'Video with Unset Resolution',
    'video_source_help' => 'Where did this video come from?',
    'video_subbed_help' => 'Set if this video has subtitles of dialogue.',
    'video_uncen_help' => 'Set if this video is an uncensored version of a censored sequence.',
    'video_unknown_source_lens' => 'Video with Unknown Source Type',
    'video_unlinked_lens' => 'Video Without Entries',
    'video' => 'Video',
    'videos' => 'Videos',
    'wiki' => 'Wiki',
    'year' => 'Year',
    'yes' => 'Yes',
    'yesterday' => 'Yesterday',
];
