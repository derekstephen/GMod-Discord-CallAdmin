local config = {}

config.Discord_AdminGroupID = "DISCORD_ROLE_ID"
config.token = "YOUR_SECRET_TOKEN"

config.Call_Admin_Bounce = "http://example.com/calladmin.php"
config.Claim_Bounce = "http://example.com/claim.php"
config.Admin_ULX_Group = "admin"

---------------
--End of config
---------------

function areAdminsOnline()
	for k,v in pairs(player.GetAll()) do
		if v:CheckGroup(config.Admin_ULX_Group) then
			return "true"
		end
	end
	return "false"
end

function someOneIsBadBoiii(goodply, badply, reason)

	local tbl = {
		["token"] = config.token,
		["calling_name"] = goodply:Nick(),
		["calling_id"] = goodply:SteamID(),
		["report_name"] = badply:Nick(),
		["report_id"] = badply:SteamID(),
		["reason"] = reason,
		["map"] = game.GetMap(),
		["server_role"] = config.Discord_AdminGroupID,
		["server"] = GetHostName(),
		["admins_online"] = areAdminsOnline(),
		["server_ip"] = game.GetIPAddress()
	}

	sendBadToDiscord(tbl)
end

function sendBadToDiscord(tbl)
	http.Post(config.Call_Admin_Bounce, tbl, function(result) print(result) end, function(ses) print(ses) end)
end

function someOneIsGoodBoiii(goodply)

	local tbl = {
		["token"] = config.token,
		["admin_name"] = goodply:Nick(),
		["server"] = GetHostName(),
		["server_ip"] = game.GetIPAddress()
	}

	sendGoodToDiscord(tbl)
end

function sendGoodToDiscord(tbl)
	http.Post(config.Claim_Bounce, tbl, function(result) print(result) end, function(ses) print(ses) end)
end
