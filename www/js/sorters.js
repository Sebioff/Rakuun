$.tablesorter.addParser(
	{
		id: "army",
		is: function(s) {
			return false;
		},
		format: function(s) {
			inout = s.replace(/\./g, "").split("/");
			build = inout[0].match(/\(\+(.+)\)/);
			sum = parseInt(inout[0]) + parseInt(inout[1]);
			if (build != null)
				sum += parseInt(build[1]);
			return jQuery.tablesorter.formatFloat(sum);
		}, 
		type: "numeric"
	}
);
$.tablesorter.addParser(
	{
		id: "username",
		is: function(s) {
			return false;
		},
		format: function(s) {
			name = s.match(/<span .+>(.+)<\/span>/);
			if (name == null) {
				name = s.match(/<a .+>(.+)<\/a>/);
			}
			return name[1].toUpperCase();
		},
		type: "text"
	}
);
$.tablesorter.addParser(
	{
		id: "mapkoords",
		is: function(s) {
			return false;
		},
		format: function(s) {
			return s.match(/<a .+>(.+)<\/a>/)[1].replace(/:/g, "");
		},
		type: "numeric"
	}
);