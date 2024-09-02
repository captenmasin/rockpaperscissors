const RouteNames = ["debugbar.openhandler",
"debugbar.clockwork",
"debugbar.assets.css",
"debugbar.assets.js",
"debugbar.cache.delete",
"horizon.stats.index",
"horizon.workload.index",
"horizon.masters.index",
"horizon.monitoring.index",
"horizon.monitoring.store",
"horizon.monitoring-tag.paginate",
"horizon.monitoring-tag.destroy",
"horizon.jobs-metrics.index",
"horizon.jobs-metrics.show",
"horizon.queues-metrics.index",
"horizon.queues-metrics.show",
"horizon.jobs-batches.index",
"horizon.jobs-batches.show",
"horizon.jobs-batches.retry",
"horizon.pending-jobs.index",
"horizon.completed-jobs.index",
"horizon.silenced-jobs.index",
"horizon.failed-jobs.index",
"horizon.failed-jobs.show",
"horizon.retry-jobs.show",
"horizon.jobs.show",
"horizon.index",
"home",
"game.new",
"game",
"game.move",
"game.join",
"game.rematch",
"game.rematch.accept",
"game.rematch.deny",
] as const 

export type RouteName = typeof RouteNames[number];